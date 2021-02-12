<?php
namespace Drupal\imd_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class ImdModuleForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'imd_module_form';
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $formState)
    {

        $form['search'] = [
            '#type' => 'textfield',
            '#prefix' => '<div class="col-3 px-1">',
            '#title' => $this->t('Search box'),
            '#default_value' => isset($_GET['q']) ? $_GET['q'] : 'Mandalorian',
            '#description' => $this->t('Enter your movie or series title'),
            '#size' => 32,
            '#suffix' => '</div>',
        ];
        $form['search']['#attributes']['class'][] = 'form-control';

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Search'),
        ];

        $form['submit']['#attributes']['class'][] = 'btn btn-primary';

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $formState)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $formState)
    {
        $data = $formState->getValue('search');
        $url = \Drupal\Core\Url::fromRoute('imd_module_body', [], ['query' => ['q' => $data]]);
        $formState->setRedirectUrl($url);
    }
}
