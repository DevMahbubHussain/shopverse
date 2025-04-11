<?php 
/**
 * Plugin name:ShopVerse
 * Plugin URI:http://mahbub.com/shopverse
 * Description:ShopVerse Lightweight Custom E-Commerce Toolkit for WP. 
 * version:1.0.0
 * Require PHP:8.0
 * Require at least:5.8
 * Author:Mahbub Hussain
 * Author URI:http://mahbub.com/
 * License:GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:shopverse
 * Domain Path:/languages
 * 
 * @package ShopVerse
 */


 /**
  * protect direct access to plugin. 
  */
if(!defined('ABSPATH')) exit;

/**
 * Main plugin class for ShopVerse.
 *
 * @package ShopVerse
 */
final class ShopVerse{

    /**
     * Plugin version
     */
    const VERSION = '1.0.0';

    /**
     * Plugin Slug
     */
    const SLUG = "shopverse";

    /**
     * Singleton Instance.
     *
     * @var ShopVerse|null
     */
    private static $instance = null;


    /**
     * Constructor:initialize the plugin.
     */
    private function __construct()
    {
        require_once __DIR__ .'/vendor/autoload.php';
        $this->defineConstant();
        $this->initHooks();
        
    }

    /**
     * Retrive the single instance of the class.
     *
     * @return ShopVerse
     */
    public static function init(){
        if(self::$instance==null){
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Defined plugin constant.
     */
    public function defineConstant(){
      define('SHOPVERSE_VERSION',self::VERSION);
      define('SHOPVERSE_SLUG',self::SLUG);
      define('SHOPVERSE_FILE',__FILE__);
      define('SHOPVERSE_DIR',__DIR__);
      define('SHOPVERSE_PATH',dirname(SHOPVERSE_FILE));
    //   define('SHOPVERSE_INCLUDES',SHOPVERSE_PATH . '/includes');
    //   define('SHOPVERSE_TEMPLATE_PATH',SHOPVERSE_PATH . '/templates');
    //   define('SHOPVERSE_URL',plugins_url('',SHOPVERSE_FILE ));
    //   define('SHOPVERSE_BUILD',SHOPVERSE_URL . '/build');
    //   define('SHOPVERSE_ASSETS',SHOPVERSE_URL . '/assets');
    }

    /**
     *  Initialize plugin hooks: activation, deactivation, localization, and settings links.
     *
     * @return void
     */
    private function initHooks(){
        //activation and deactivation
        register_activation_hook(__FILE__, [ $this,'activatePlugin' ]);
        register_deactivation_hook(__FILE__, [ $this,'deactivatePlugin' ]);

        // plugin localization 
        add_action("init", [ $this, 'localizationSetup' ]);

        // Plugin action links
        // add_filter('plugin_action_links_' . plugin_basename(__FILE__), [ $this,'pluginActionLinks' ]);
    }
    
    /**
     * Plugin activate callback.
     *
     * @return void
     */
    public function activatePlugin(){}

     /**
     * Plugin deactivate callback.
     *
     * @return void
     */
    public function deactivatePlugin(){
        $this->flushRewriteRule();
    }

    /**
     * Flush Rewrite.
     *
     * @return void
     */
    public function flushRewriteRule(){
        flush_rewrite_rules();
    }

    /**
     * Plugin action links callback.
     *
     * @return void
     */
    // public function pluginActionLinks(){}
    
    /**
     * Set up the localization.
     *
     * @return void
     */
    public function localizationSetup(){
        load_plugin_textdomain('shopverse', false, dirname(plugin_basename(__FILE__ ) . '/languages'));
    }

    /**
     * Prevent the cloning of the instance.
     *
     * @return void
     */
    public function __clone(){}

    /**
     *  Prevent the unserializing  of the instance.
     */
    public function __wakeup()
    {
         throw new \Exception("Cannot unserialize a singleton.");
    }
}

/**
 * Initialize the plugin.
 *
 * @return \ShopVerse
 */
function shopVerse(){
    return ShopVerse::init();
}

// Kick of the plugin.
shopVerse();