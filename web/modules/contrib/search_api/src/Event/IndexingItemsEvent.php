<?php

namespace Drupal\search_api\Event;

use Drupal\search_api\IndexInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Wraps an indexing items event.
 */
class IndexingItemsEvent extends Event {

  /**
   * The index on which items will be indexed.
   *
   * @var \Drupal\search_api\IndexInterface
   */
  protected $index;

  /**
   * The items that will be indexed.
   *
   * @var \Drupal\search_api\Item\ItemInterface[]
   */
  protected $items;

  /**
   * Constructs a new class instance.
   *
   * @param \Drupal\search_api\IndexInterface $index
   *   The index on which items will be indexed.
   * @param \Drupal\search_api\Item\ItemInterface[] $items
   *   The items that will be indexed.
   */
  public function __construct(IndexInterface $index, array $items) {
    $this->index = $index;
    $this->items = $items;
  }

  /**
   * Retrieves the index on which items will be indexed.
   *
   * @return \Drupal\search_api\IndexInterface
   *   The index on which items will be indexed.
   */
  public function getIndex() {
    return $this->index;
  }

  /**
   * Retrieves the items that will be indexed.
   *
   * @return \Drupal\search_api\Item\ItemInterface[]
   *   The items that will be indexed.
   */
  public function getItems() {
    return $this->items;
  }

  /**
   * Sets the items that will be indexed.
   *
   * @param \Drupal\search_api\Item\ItemInterface[] $items
   *   The new items that will be indexed.
   */
  public function setItems(array $items) {
    $this->items = $items;
  }

}
