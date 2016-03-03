<?php

/**
 * Description of NzBootstrap
 *
 * @author tino
 */
class NzBootstrap
{

    public function __construct()
    {
        $this->loadDependencies();
    }

    public function loadDependencies()
    {
        include_once __DIR__ . '/Modals.php';
    }

    public function init()
    {
        $modals = new NzBsModals();

        add_action('init', [$modals, 'add_shortcodes']);
        add_action('wp_footer', [$modals, 'print_modals']);
    }
}
