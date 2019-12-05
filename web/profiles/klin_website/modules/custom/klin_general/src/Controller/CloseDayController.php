<?php
/**
 * Created by PhpStorm.
 * User: lion115
 * Date: 05.12.19
 * Time: 16:06
 */

namespace Drupal\klin_general\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
class CloseDayController extends ControllerBase
{
    /** @var $request RequestStack */
    private $request;

    public function __construct()
    {
        $this->request = \Drupal::request();
    }

    public function closeDay()
    {
        $node = Node::load($this->request->get('id'));
        try{
            $node->set('field_close_day', date("Y-m-d\TH:i:s", time()));
            $node->save();
            return new JsonResponse(['status' => 'ok']);
        }catch (Exception $exception){
            \Drupal::logger('klin_general')->notice($exception);
            throw new HttpException('Something went wrong!', 500);
        }
    }

    public function reopenDay()
    {
        $node = Node::load($this->request->get('id'));
        try{
            $node->set('field_close_day', []);
            $node->save();
            return new JsonResponse(['status' => 'ok']);
        }catch (Exception $exception){
            \Drupal::logger('klin_general')->notice($exception);
            throw new HttpException('Something went wrong!', 500);
        }
    }
}
