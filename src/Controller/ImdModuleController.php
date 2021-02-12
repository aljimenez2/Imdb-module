<?php

namespace Drupal\imd_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\imd_module\ImdService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\Markup;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Class ImdCustomController.
 */
class ImdModuleController extends ControllerBase
{
  /**
   * The imdService Connection.
   *
   * @var \Drupal\imd_module\service\ImdService
   */
  protected $imdService;

  /**
   * {@inheritdoc}
   */
    public static function create(ContainerInterface $container) {
        $controller = new static(
            $container->get('imd_module.default')
          );
          return $controller;
    }

    /**
     * ImdService constructor.
     *
     * @param ImdService $imdService
     */
    public function __construct( ImdService $imdService)
    {
        $this->imdService = $imdService;
    }

    /**
     * Creating the Body of our module
     */
    public function body()
    {
        $q = isset($_GET['q']) ? $_GET['q'] : 'mandalorian';
        $actorsData =  $this->imdService->getActorData($q);
        $header = [
            ['data' => $this->t('ID')],
            ['data' => $this->t('Series')],
            ['data' => $this->t('Image')],
            ['data' => $this->t('Actor/Actress name')],
        ];
        $rows = [];
        foreach ($actorsData->d as $key => $row) {
            /** 
             * Discomment this section to see the response body for each row
            */
            // echo "<pre>", print_r($row),"</pre>";

            /**
            * Passing the Data needed to the rows for the image we use 
            * FormattableMarkup that render a image into the table
            */
            $rows[] = ['data' => [
                'ID' => $row->id,
                'Series' => $row->l,
                'Image' => new FormattableMarkup('<img src="@image" alt="@alter" width="60px" height="80px"/>', [
                    '@image' => $row->i->imageUrl,
                    '@alter' => $row->l
                  ]),
                'Actor/Actress name' => $row->s
            ]];
        }
        
        /**
            * Rendering our Form to use it to search the moview of series that we want
        */  
        $form = \Drupal::formBuilder()->getForm('Drupal\imd_module\Form\ImdModuleForm');
        $renderer = \Drupal::service('renderer');
        $myFormHtml = $renderer->render($form);


        $build['search_fox'] = [
            '#markup' => Markup::create("
                {$myFormHtml}
            ")
        ];
        
        $build['tablesort_table'] = [
            '#theme' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#type' => 'table',
        ];
    
        return $build;
    }
}
