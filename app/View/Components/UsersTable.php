<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class UsersTable extends Component
{

    // TODO! EXTEND CLASS TABLE FROM WHICH YOU WILL INHERIT ALL VARIABLES NOT
    // SPECIFIC TO USER TABLE, BUT COMMON TO PAGES AND ROLES TABLE, AND OTHERS

    public string $table;
    public EloquentCollection $items;
    // public Collection $pages;
    // public int $currentPage;
    public string $queryString;

    public array $headers;
    // public array $formatedItems;

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
        return view('components.users-table');
    }

    private function prepareTable(): void{
    
        // Set headers
        $this->headers = [
            __('Username'), __('First name'), __('Last name'), __('Email'), __('Role'), __('Actions')
        ];
        
    }
}
