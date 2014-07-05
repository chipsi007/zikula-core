<?php
/**
 * Copyright Zikula Foundation 2013 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

namespace Zikula\Module\SearchModule\Controller;

use Zikula_View;
use ModUtil;
use SecurityUtil;
use EventUtil;
use System;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Zikula\Module\SearchModule\AbstractSearchable;

/**
 * Administrative controllers for the search module
 */
class AdminController extends \Zikula_AbstractController
{
    /**
     * Post initialise.
     *
     * @return void
     */
    protected function postInitialize()
    {
        // In this controller we do not want caching.
        $this->view->setCaching(Zikula_View::CACHE_DISABLED);
    }

    /**
     * The main administration function.
     *
     * @return RedirectResponse
     */
    public function mainAction()
    {
        // Security check will be done in modifyconfig()
        return new RedirectResponse(System::normalizeUrl(ModUtil::url($this->name, 'admin', 'modifyconfig')));
    }

    /**
     * Display a form to modify the module configuration
     *
     * @return Response symfony response object
     *
     * @throws AccessDeniedException Thrown if the user doesn't have admin access to the module
     */
    public function modifyconfigAction()
    {
        // Security check
        if (!SecurityUtil::checkPermission('ZikulaSearchModule::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException();
        }

        // get all the LEGACY (<1.4.0) search plugins
        $plugins = ModUtil::apiFunc('ZikulaSearchModule', 'user', 'getallplugins', array('loadall' => true));
        $plugins = false === $plugins ? array() : $plugins;

        // get 1.4.0+ type searchable modules and add to array
        $searchableModules = ModUtil::getModulesCapableOf(AbstractSearchable::SEARCHABLE);
        foreach ($searchableModules as $searchableModule) {
            $plugins[] = array('title' => $searchableModule['name']);
        }

        // get the disabled status
        foreach ($plugins as $key => $plugin) {
            if (isset($plugin['title'])) {
                $plugins[$key]['disabled'] = $this->getVar("disable_$plugin[title]");
            }
        }

        // assign all module vars
        $this->view->assign($this->getVars());

        // assign the plugins
        $this->view->assign('plugins', $plugins);

        // Return the output that has been generated by this function
        return $this->view->fetch('Admin/modifyconfig.tpl');
    }

    /**
     * Update the module configuration
     *
     * @return RedirectResponse
     *
     * @throws AccessDeniedException Thrown if the user doesn't have admin access to the module
     */
    public function updateconfigAction()
    {
        $this->checkCsrfToken();

        // Security check
        if (!SecurityUtil::checkPermission('ZikulaSearchModule::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException();
        }

        // Update module variables.
        $itemsperpage = $this->request->request->filter('itemsperpage', 10, false, FILTER_VALIDATE_INT);
        $this->setVar('itemsperpage', $itemsperpage);
        $limitsummary = $this->request->request->filter('limitsummary', 255, false, FILTER_VALIDATE_INT);
        $this->setVar('limitsummary', $limitsummary);
        $opensearchAdultContent = $this->request->request->filter('opensearch_adult_content', false, false, FILTER_VALIDATE_BOOLEAN);
        $this->setVar('opensearch_adult_content', $opensearchAdultContent);
        $opensearchEnabled = $this->request->request->filter('opensearch_enabled', false, false, FILTER_VALIDATE_BOOLEAN);
        $this->setVar('opensearch_enabled', $opensearchEnabled);

        $disable = $this->request->request->get('disable', null);
        // get all the LEGACY (<1.4.0) search plugins
        $plugins = ModUtil::apiFunc('ZikulaSearchModule', 'user', 'getallplugins', array('loadall' => true));
        // get 1.4.0+ type searchable modules and add to array
        $searchableModules = ModUtil::getModulesCapableOf(AbstractSearchable::SEARCHABLE);
        foreach ($searchableModules as $searchableModule) {
            $plugins[] = array('title' => $searchableModule['name']);
        }

        // loop round the plugins
        foreach ($plugins as $searchplugin) {
            // set the disabled flag
            if (isset($disable[$searchplugin['title']])) {
                $this->setVar("disable_$searchplugin[title]", true);
            } else {
                $this->setVar("disable_$searchplugin[title]", false);
            }
        }

        // the module configuration has been updated successfuly
        $this->request->getSession()->getFlashBag()->add('status', $this->__('Done! Saved module configuration.'));

        // This function generated no output, and so now it is complete we redirect
        // the user to an appropriate page for them to carry on their work
        return new RedirectResponse(System::normalizeUrl(ModUtil::url($this->name, 'admin', 'modifyconfig')));
    }
}
