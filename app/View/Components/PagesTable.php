<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;


class PagesTable extends Component
{
    public string $table;
    public EloquentCollection $items;
    public string $queryString;

    public array $headers;
    // public array $formatedItems; 

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($table, $items, $queryString){
        $this->table = $table;
        $this->items = $items;
        $this->queryString = $queryString;

        $this->prepareTable();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pages-table');
    }

    private function prepareTable(): void{
        $this->headers = [
            __('Title'), __('Slug'), __('Author'), __('Published'), __('Actions')
        ];
    }
}
