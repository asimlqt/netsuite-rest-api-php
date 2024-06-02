<?php

namespace NetsuiteRestApi\Pagination;

use ReturnTypeWillChange;

class Cursor implements \Iterator
{
    protected Page $currentPage;
    protected int $currentIndex = 0;
    protected int $totalIndex = 0;

    public function __construct(
        private readonly Page $firstPage
    ) {
        $this->currentPage = $this->firstPage;
    }

    #[ReturnTypeWillChange]
    public function current()
    {
        return $this->currentPage->getItems()[$this->currentIndex];
    }

    public function next(): void
    {
        $this->currentIndex++;
        $this->totalIndex++;

        $items = $this->currentPage->getItems();

        if (!isset($items[$this->currentIndex]) && $this->currentPage->hasNextPage()) {
            $this->currentIndex = 0;
            $this->currentPage = $this->currentPage->getNextPage();
        }
    }

    #[ReturnTypeWillChange]
    public function key()
    {
        return $this->totalIndex;
    }

    public function valid(): bool
    {
        return isset($this->currentPage->getItems()[$this->currentIndex]);
    }

    public function rewind(): void
    {
        $this->totalIndex = 0;
        $this->currentIndex = 0;
        $this->currentPage = $this->firstPage;
    }
}
