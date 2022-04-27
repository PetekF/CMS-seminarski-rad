<?php

namespace App\View\Components;


use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RolesTable extends Component
{
    public string $table;
    public EloquentCollection $items;
    // public Collection $pages;
    // public int $currentPage;
    public string $queryString;

    public array $headers;
    public array $formatedItems; // together with actions

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($table, $items, $queryString)
    {
        $this->table = $table;
        $this->items = $items;
        // $this->pages = $pages;
        // $this->currentPage = $currentPage;
        $this->queryString = $queryString;

        $this->prepareTable();

        // dd($this->table, $this->items, $this->pages, $this->currentPage);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.roles-table');
    }

    private function prepareTable(): void{
    
        // Set headers
        $this->headers = [
            __('Name'), __('Actions')
        ];
        

        // Choose appropriate user info and add actions
        // $this->formatedItems = new Collection();

        $this->formatedItems = [

        ];
    }
}
