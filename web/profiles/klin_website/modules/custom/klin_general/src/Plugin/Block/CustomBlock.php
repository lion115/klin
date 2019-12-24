<?php
namespace Drupal\klin_general\Plugin\Block;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\NodeInterface;


/**
 * Provides a 'Vkc contact' block.
 *
 * @Block(
 *   id = "klin_custom_block",
 *   admin_label = @Translation("Custom block"),
 *   category = @Translation("Custom")
 * )
 */

class CustomBlock extends BlockBase implements BlockPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build() {
        $node = \Drupal::routeMatch()->getParameter('node');
        $total = 0;
        if ($node instanceof NodeInterface && $node->bundle() === 'customer') {
            $connection = \Drupal::database();
            $qb = $connection->query(
                'Select field_price_value FROM node__field_price np
                    Left Join node__field_customer_title nct ON nct.field_customer_title_target_id = ' . $node->id() . '
                    Left Join node__field_close_day cd ON cd.entity_id = nct.entity_id
                    Where np.entity_id IN (cd.entity_id);');
            while ($result = $qb->fetchAssoc()) {
                $total += $result['field_price_value'];
            }
        }
        $build = array(
            '#markup' => $total . ' UAH'
        );

        return $build;
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);

        $config = $this->getConfiguration();

        $form['contact_text'] = array(
            '#type' => 'text_format',
            '#title' => $this->t('Some Info'),
            '#default_value' => isset($config['contact_text']['value']) ? $config['contact_text']['value'] : ''
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state)
    {
        parent::blockSubmit($form, $form_state);
        $this->configuration['contact_text'] = $form_state->getValue('contact_text');
    }

    public function getCacheMaxAge() {
        return 0;
    }
}
