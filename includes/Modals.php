<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modals
 *
 * @author tino
 */
class NzBsModals
{

    private $modals;

    public function add_shortcodes()
    {
        add_shortcode('nz_bs_modals_trigger', array($this, 'add_modal_trigger'));
        add_shortcode('nz_bs_modals_content', array($this, 'add_modal_content'));
    }

    private function error($msg)
    {
        if (current_user_can('manage_options')) {

            return $msg;
        }
    }

    public function add_modal_trigger($options, $content)
    {
        d('trigger', $content);
        $opt = array_merge(array(
            'id' => false,
            'class' => '',
            'iconclass' => '',
            'title' => false,
            ), $options);

        extract($opt);

        if (!$id) {
            return $this->error('id="blah" param missing from modal trigger');
        }
        if (!$iconclass) {
            return $this->error('iconclass="blah" param missing from modal trigger');
        }
        if (!$title) {
            return $this->error('title="blah" param missing from modal trigger');
        }
        $trigger_format = '<a class="%s" href="#%s" data-toggle="modal">%s</a>';
        $inner_format = '<i class="%s"></i>%s';

        $inner = sprintf($inner_format, $iconclass, $title);

        return sprintf($trigger_format, $class, $id, $inner);
    }

    public function add_modal_content($options, $content)
    {
        d('content', $content);

        $opt = array_merge(array(
            'id' => false,
            ), $options);

        if (!$opt['id']) {
            return $this->error('id="blah" param missing');
        }
        $this->modals[$opt['id']] = $content;
    }

    public function print_modals()
    {
        if (!empty($this->modals)) {
            ?>
            <!--<div id="hidden-modals">-->
            <?php
            foreach ($this->modals as $k => $modal) {
                d($modal);
                ?>
                <div class="full-screen-modal modal fade" id="<?php echo $k ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-content">
                        <div class="close-modal" data-dismiss="modal">
                            <div class="lr">
                                <div class="rl">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 col-lg-offset-2">
                                    <div class="modal-body"><?php echo $modal; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <!--</div>-->
            <?php
        }
    }
}

function shortcode_empty_paragraph_fix( $content ) {

    // define your shortcodes to filter, '' filters all shortcodes
    $shortcodes = array( 'your_shortcode_1', 'your_shortcode_2' );
    
    foreach ( $shortcodes as $shortcode ) {
        
        $array = array (
            '<p>[' . $shortcode => '[' .$shortcode,
            '<p>[/' . $shortcode => '[/' .$shortcode,
            $shortcode . ']</p>' => $shortcode . ']',
            $shortcode . ']<br />' => $shortcode . ']'
        );

        $content = strtr( $content, $array );
    }

    return $content;
}

add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );