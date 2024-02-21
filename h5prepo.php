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
    





    
        /**
     * Register templates
     *
     * @return void
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates/';
        array_splice($this->grav['twig']->twig_paths, 0, 1);
        //$this->grav['debugger']->addMessage("here1");
        //$this->grav['debugger']->addMessage($this->grav['twig']->twig_paths);
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
        //$this->grav['debugger']->addMessage("here");
        //$this->grav['debugger']->addMessage($paths);
    }
    
    
}
