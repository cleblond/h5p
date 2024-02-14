<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Events\FlexRegisterEvent;

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
        if ($this->isAdmin()) {
            return;
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
    
    
        
    public function onAdminAfterSaveAs($event)
    {
        $type = $event['type'];
        $object = $event['object'];
        //dump($event);
                //dump("HERE");
        //$this->grav['debugger']->addMessage($event);
        //set commit message for flex objects
        if($type === 'flex'){
            
            //my functions here
        }
    }
    
    
    
    
    public function onFlexAfterSave($event)
    {
        $type = $event['type'];
        $object = $event['object'];
        //dump($event);
        
        $this->grav['debugger']->addMessage($event);
        //set commit message for flex objects
        if($type === 'flex'){
            
            //my functions here
        }
    }
    
    
    
}
