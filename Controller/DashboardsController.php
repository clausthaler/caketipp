<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class DashboardsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
    public $name = 'Dashboards';

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array('Match', 'Feed');

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
    public function index() {
      $this->set('feeds', $this->Feed->find('threaded'));
      $this->set('title_for_layout', 'User Dashboard');
    }



    public function pdf() {
        Configure::write('debug', 0);
        $this->RequestHandler->addInputType('json', array('json_decode', true));

        if ($this->request->is('ajax') & !empty($this->request->data)) {
            $this->disableCache();

            App::import('Vendor','xtcpdf'); 
            App::uses('String', 'Utility');
            App::uses('File', 'Utility');
            $fileName = String::uuid() . '.pdf';

            $pdf = new XTCPDF('P', 'pt', 'A4', true, 'UTF-8');
            $pdf->SetAuthor('Tetrixx');
            $pdf->SetTitle('Schnittplan');
            $pdf->SetMargins(15, 15, 15, 15);           
            $pdf->SetAutoPageBreak(false);
            $leftindent = 70;
            $topindent = 70;
            $cutLineStyle = array('width' => 0.1, 'color' => array(GREY));

            foreach ($this->request->data as $matkey => $material) {
            
                // calculate page orientation
                if ($material['width'] <= $material['height']) {
                    // Portrait
                    $orientation = 'P';
                } else {
                    // Landscape
                    $orientation = 'L';
                }

                // stretch/shrink material to fill the page
                // calculater transform factor for portrait
                if ($orientation == 'P') {
                // max width = 500
                // max height = 750
                    $xmax = 470;
                    $ymax = 700;
                } else {
                    // max width = 750
                    // max height = 500
                    $xmax = 700;
                    $ymax = 470;
                }

                // calculate transform factor dependand on measures
                if ($material['width'] >= $xmax && $material['height'] >= $ymax) {
                    // height and width bigger than page
                    $xdiff = $material['width'] - $xmax;
                    $ydiff = $material['height'] - $ymax;
                    if ($xdiff > $ydiff) {
                        $factor = $material['width'] / $xmax;
                    } else {
                        $factor = $material['height'] / $ymax;
                    }
                } elseif ($material['width'] >= $xmax) {
                    // width bigger than page width
                    $factor = $material['width'] / $xmax;
                } elseif ($material['height'] >= $ymax) {
                    // height bigger than page height
                    $factor = $material['height'] / $ymax;
                } else {
                    $xdiff = $xmax - $material['width'];
                    $ydiff = $ymax - $material['height'];
                    if ($xdiff < $ydiff) {
                        $factor = $material['width'] / $xmax;
                    } else {
                        $factor = $material['height'] / $ymax;
                    }

                }
                
                $this->log($factor);
                $pdf->AddPage($orientation);
                $pdf->SetFont('times', '', 12);
                $pdf->text($leftindent, 10, $material['name']);
                $pdf->SetFont('times', '', 8);
                $pdf->text($leftindent, 25, $material['width'] . 'mm x ' . $material['height'] . 'mm, Schnittbreite ' . $material['cutwidth'] . 'mm');
                $pdf->Rect($leftindent, $topindent, $material['width'] / $factor, $material['height'] / $factor);

                $xcuts = array();
                $ycuts = array();
                
                foreach ($material['elements'] as $key => $value) {

                    // correct offset
                    $value['x'] = $value['x'] -10;
                    $value['y'] = $value['y'] -10;

                    // add cut to cuts array
                    // horizontal
                    if (!in_array(($value['x'] + $value['width']), $xcuts) && $value['width'] <> $material['width'] && ($value['x'] + $value['width']) <> $material['width']) {
                        $xcuts[] = $value['x'] + $value['width'];
                    }
                    if (!in_array(($value['x']), $xcuts) && $value['x'] <> '0' && !in_array(($value['x'] - $material['cutwidth']), $xcuts)) {
                        $xcuts[] = $value['x'];
                    }

                    // vertical
                    if (!in_array(($value['y'] + $value['height']), $xcuts) && $value['height'] <> $material['height'] && ($value['y'] + $value['height']) <> $material['height']) {
                        $ycuts[] = $value['y'] + $value['height'];
                    }
                    if (!in_array(($value['y']), $ycuts) && $value['y'] <> '0' && !in_array(($value['y'] - $material['cutwidth']), $ycuts)) {
                        $ycuts[] = $value['y'];
                    }

                    $styleNoBorder = array('L' => 0,
                        'T' => 0,
                        'R' => 0,
                        'B' => 0);
                    $styleRect = array('L' => 0.5,
                        'T' => 0.5,
                        'R' => 0.5,
                        'B' => 0.5);
                    if ($value['clearcut'] == 'true') {
                        $pdf->Rect($value['x'] / $factor + $leftindent, $value['y'] / $factor + $topindent, $value['width'] / $factor, $value['height'] / $factor, 'DF', $styleNoBorder, array(230,230,230));
                    } else {
                        $pdf->Rect($value['x'] / $factor + $leftindent, $value['y'] / $factor + $topindent, $value['width'] / $factor, $value['height'] / $factor, 'DF', $styleRect, array(0, 255, 255));
//                      $pdf->text($value['x'] + 3, $value['y'] + 33, $value['text']);
                    }
                }
                
                $odd = false;
                $oddOffset = 0;
                asort($xcuts);
                asort($ycuts);
                
                foreach ($xcuts as $key => $xcut) {
                    if ($xcut < 100) {
                        $indent = 7;
                    } else {
                        $indent = 10;
                    }
                    
                    if ($odd) {
                        $oddOffset = 10;
                        $odd = false;
                    } else {
                        $oddOffset = 0;
                        $odd = true;
                    }
                    
                    $pdf->text($xcut / $factor + $leftindent - $indent, 37 + $oddOffset, $xcut);
                    $pdf->text($xcut / $factor + $leftindent - $indent, $material['height'] / $factor + $topindent + 20 + $oddOffset, $xcut);
                    $pdf->Line($xcut / $factor + $leftindent, 47 + $oddOffset, $xcut / $factor + $leftindent, $material['height'] / $factor + 20 + $topindent + $oddOffset, $cutLineStyle);


                }

                foreach ($ycuts as $key => $ycut) {
                    if ($ycut > 1000) {
                        $indent = 10;
                    } elseif ($ycut > 100) {
                        $indent = 10;
                    } else {
                        $indent = 10;
                    } 
                    
                    $pdf->text(20, $ycut / $factor + $topindent - 5, $ycut);
                    $pdf->text($material['width'] / $factor + $leftindent + 25, $ycut / $factor + $topindent - 5, $ycut);

                    $pdf->Line(30 + $indent, $ycut / $factor + $topindent, $material['width'] / $factor + $leftindent + 20 , $ycut / $factor + $topindent, $cutLineStyle);
                }
            }

            $file = new File(APP . DS . WEBROOT_DIR . DS . 'files' . DS . $fileName);
            $file->delete();

            $pdf->Output(APP . DS . WEBROOT_DIR . DS . 'files' . DS . $fileName, 'F');
        
            $response = $this->request->data;
            $response = array('status' => 1, 'file' => $fileName);
            $this->set(compact('response'));

        } else {
            $response = array('status' => 1);
            $this->set('response');
        }

    }
}
