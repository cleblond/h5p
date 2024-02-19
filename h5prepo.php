<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Events\FlexRegisterEvent;
use ZipArchive;
use RocketTheme\Toolbox\Event\Event;
/**
 * Class H5prepoPlugin
 * @package Grav\Plugin
 */
class H5prepoPlugin extends Plugin
{
    public $features = [
        'blueprints' => 0,
    ];

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                // Uncomment following line when plugin requires Grav < 1.7
                // ['autoload', 100000],
                ['onPluginsInitialized', 0]
                
                
                ],
                'onAssetsInitialized'  => [['onAssetsInitialized', 0]],
                'onFlexAfterSave'  => [['onFlexAfterSave', 0]],
                //'onTwigTemplatePaths'  => [['onTwigTemplatePaths', 0]],
                //'onAdminTwigTemplatePaths' => [['onAdminTwigTemplatePaths', 0]],
                
                
            FlexRegisterEvent::class       => [['onRegisterFlex', 0]],
        ];
    }

    /**
     * Composer autoload
     *
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        
        /*
        if ($this->isAdmin()) {
            return;
        }
        */
        if ($this->isAdmin()) {
        
           $this->enable([
                /*'onAdminTwigTemplatePaths' => [
                    ['onAdminTwigTemplatePaths', 10]
                ],*/
                'onTwigTemplatePaths'  => [['onTwigTemplatePaths', 0]],
                'onAssetsInitialized'  => [['onAssetsInitialized', 0]],
                
                ]);
        
        }
        
        
        
        
        // Enable the main events we are interested in
        $this->enable([
            // Put your main events here
        ]);
    }

    public function onRegisterFlex($event): void
    {
        $flex = $event->flex;

        $flex->addDirectoryType(
            'h5pobj',
            'blueprints://flex-objects/h5pobj.yaml'
        );

    }
    
    
    
    public function onFlexAfterSave($event)
    {
        //$type = $event['type'];
        $object = $event['object'];

        //$this->grav['debugger']->addMessage($object->getFlexType());

        if ($object->getFlexType() == 'h5pobj') {

		$folder = $object->getStorageKey();
		
		$shortcode = "[h5prepo id=" . $folder . "]";
		$object->setProperty('shortcode', $shortcode);
		$object->save();

		$json = file_get_contents('/var/www/html/learn/user/data/h5pobj/'.$object->getStorageKey().'/item.json'); 

		$jsonobj = json_decode($json);   

		foreach ($jsonobj->custom_file as $file) {
		// Access the path of each file
		$tpath = $file->path;

		}

		$pieces = explode("//", $tpath);
		$path = $pieces[1];



		$zip = new ZipArchive();
		$filename = '';
		$res = $zip->open('/var/www/html/learn/user/plugins/'.$path);
		
		if ($res === TRUE) {
		$zip->extractTo('/var/www/html/learn/user/data/h5pobj/'.$folder);
		$zip->close();
		} 
      	}
    }
    


    public function onAssetsInitialized()
    {
    
    
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/jquery.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/h5p.js');   
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/h5p-event-dispatcher.js');    
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/h5p-x-api-event.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/h5p-x-api.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/h5p-content-type.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/h5p-confirmation-dialog.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/h5p-action-bar.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/request-queue.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-php-library/js/h5p-tooltip.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5p-hub-client.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5p-hub-client.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-editor.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/language/en.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor.js'); 
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-semantic-structure.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-library-selector.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-fullscreen-bar.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-form.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-text.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-html.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-number.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-textarea.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-file-uploader.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-file.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-image.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-image-popup.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-av.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-group.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-boolean.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-list.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-list-editor.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-library.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-library-list-cache.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-select.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-selector-hub.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-selector-legacy.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-dimensions.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-coordinates.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-none.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-metadata.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-metadata-author-widget.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-metadata-changelog-widget.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/scripts/h5peditor-pre-save.js');
$this->grav['assets']->addJs('plugin://' . $this->name . 'h5p-editor-php-library/ckeditor/ckeditor.js');
    
    
    
    
    
        $this->grav['assets']->addJs('plugin://' . $this->name . '/js/my-script.js');
    }


    
        /**
     * Register templates
     *
     * @return void
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates/';
        array_splice($this->grav['twig']->twig_paths, 0, 1);
        $this->grav['debugger']->addMessage("here1");
        $this->grav['debugger']->addMessage($this->grav['twig']->twig_paths);
    }
    
    public function onAdminTwigTemplatePaths(Event $event): void
    {
        $extra_admin_twig_path = $this->config->get('plugins.h5prepo.extra_admin_twig_path');
        $extra_path = $extra_admin_twig_path ? $this->grav['locator']->findResource($extra_admin_twig_path) : null;

        $paths = $event['paths'];
        if ($extra_path) {
            $paths[] = $extra_path;
        }

        $paths[] = __DIR__ . '/admin/templates/';
        $event['paths'] = $paths;
        //error_log(print_r($this->grav['twig']->twig_paths, true));
        $this->grav['debugger']->addMessage("here");
        $this->grav['debugger']->addMessage($paths);
    }
    
    
}
