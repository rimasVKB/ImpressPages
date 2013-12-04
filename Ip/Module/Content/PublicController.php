<?php
/**
 * @package ImpressPages
 *
 */
namespace Ip\Module\Content;


class PublicController extends \Ip\Controller
{
    public function index()
    {
        $currentPage = ipContent()->getCurrentPage();

        //redirect if needed
        if (in_array($currentPage->getType(), array('subpage', 'redirect')) && !ipIsManagementState()) {
            return new \Ip\Response\Redirect($currentPage->getLink());
        }

        //change layout if safe mode
        if (\Ip\Module\Admin\Service::isSafeMode()) {
            ipSetLayout(ipFile('Ip/Module/Admin/view/safeModeLayout.php'));
        } else {
            ipSetLayout(Service::getPageLayout($currentPage));
        }

        //initialize management
        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/content.js'));
        if (ipIsManagementState()) {
            $this->initManagement();
        } else {
            if (\Ip\Module\Admin\Backend::userId()) {
                //user has access to the backend
                ipAddJavascriptVariable('ipContentShowEditButton', 1);
            }
        }

        //show error404 page if needed
        if (
            ipContent()->getLanguageUrl() != ipContent()->getCurrentLanguage()->getUrl() ||
            $currentPage instanceof \Ip\Page404
        ) {
            return new \Ip\Response\PageNotFound();
        }

        //show page content
        $response = ipResponse();
        $response->setDescription(\Ip\ServiceLocator::content()->getDescription());
        $response->setKeywords(ipContent()->getKeywords());
        $response->setTitle(ipContent()->getTitle());


        return $currentPage->generateContent();
    }

    private function initManagement()
    {
        $widgets = Service::getAvailableWidgets();
        $snippets = array();
        foreach($widgets as $widget) {
            $snippets = array_merge($snippets, $widget->adminSnippets());
        }
        ipAddJavascriptVariable('ipWidgetSnippets', $snippets);

        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/tinymce/paste_preprocess.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/tinymce/min.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/tinymce/med.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/tinymce/max.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/tinymce/table.js'));

        ipAddCss(ipFileUrl('Ip/Module/Ip/assets/bootstrap/bootstrap.css'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/bootstrap/bootstrap.js'));


        ipAddJavascriptVariable('ipContentInit', Model::initManagementData());

        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/ipContentManagement.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/jquery.ip.contentManagement.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/jquery.ip.pageOptions.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/jquery.ip.widgetbutton.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/jquery.ip.block.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/jquery.ip.widget.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/exampleContent.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Content/assets/drag.js'));


        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/js/jquery-ui/jquery-ui.js'));
        ipAddCss(ipFileUrl('Ip/Module/Ip/assets/js/jquery-ui/jquery-ui.css'));

        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/js/jquery-tools/jquery.tools.ui.scrollable.js'));

        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/js/tiny_mce/jquery.tinymce.min.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/js/tiny_mce/tinymce.min.js'));

        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/js/plupload/plupload.full.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/js/plupload/plupload.browserplus.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/js/plupload/plupload.gears.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Ip/assets/js/plupload/jquery.plupload.queue/jquery.plupload.queue.js'));


        ipAddJavascript(ipFileUrl('Ip/Module/Upload/assets/jquery.ip.uploadImage.js'));
        ipAddJavascript(ipFileUrl('Ip/Module/Upload/assets/jquery.ip.uploadFile.js'));

        ipAddCss(ipFileUrl('Ip/Module/Content/assets/widgets.css'));
        ipAddJavascriptVariable('isMobile', \Ip\Internal\Browser::isMobile());

    }

}