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
        
        /*
        if ($this->isAdmin()) {
            return;
        }
        */
        
        //dump($this);
        //$this->grav['debugger']->addMessage("Here");
        //$this->grav['debugger']->addMessage($this);
        
        /*
        $this->grav['log']->warning('My warning message');
	$this->grav['log']->error('My error message');
	$this->grav['log']->critical('My critical message');
	$this->grav['log']->alert('My alert message');
	$this->grav['log']->emergency('Emergency, emergency, there is an emergency here!');
        */
        
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
    
    /*
        
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
    */
    
    
    
    public function onFlexAfterSave($event)
    {
        $type = $event['type'];
        $object = $event['object'];
        //dump($event);
        $this->grav['debugger']->addMessage("Here");
        $this->grav['debugger']->addMessage($event);
        $this->grav['debugger']->addMessage($object);
        $flexdir = $object->getFlexDirectory();
        
        $this->grav['debugger']->addMessage($flexdir->getObject());
        //$this->grav['debugger']->addMessage($object->getFlexKey());
        $this->grav['debugger']->addMessage($object->getStorageKey());  
        $this->grav['debugger']->addMessage(__DIR__);    
        
        $folder = $object->getStorageKey();
        
        // __DIR__ 
        
        $json = file_get_contents('/var/www/html/learn/user/data/h5pobj/'.$object->getStorageKey().'/item.json'); 
        
        $this->grav['debugger']->addMessage($json);
        
        $jsonobj = json_decode($json);   
        $this->grav['debugger']->addMessage($jsonobj->custom_file);
        
        
        $zip = new ZipArchive();
	//$res = $zip->open('file.zip');
	if ($res === TRUE) {
	$zip->extractTo('/myzips/extract_path/');
	$zip->close();
	echo 'woot!';
	} else {
	echo 'doh!';
	}

        
        
        /*
        $this->grav['log']->info('My informational message');
	$this->grav['log']->notice('My notice message');
	$this->grav['log']->debug('My debug message');
	$this->grav['log']->warning('My warning message');
	$this->grav['log']->error('My error message');
	$this->grav['log']->critical('My critical message');
	$this->grav['log']->alert('My alert message');
	$this->grav['log']->emergency('Emergency, emergency, there is an emergency here!');
        */
        
        
        //set commit message for flex objects
        if($type === 'flex'){
            
            //$json = file_get_contents('my_data.json'); 
            
            
            //my functions here
        }
    }
    
    
    
}
