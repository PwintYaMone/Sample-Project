<?php

namespace App\Exports;
use App\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;


    /**Display department export , Collection , Heading ,Title
    *@author Pwint Ya Mone
    *@date 28/08/2020
    * @return \Illuminate\Support\Collection
    */

class DepartmentsExport implements FromCollection,WithHeadings, WithTitle
{
  
    protected  $search_data;
    
    		public function __construct(  $search_data)
    		{
        		$this->search_data=  $search_data;
            //dd($this->search_data);
   			}
    public function collection()
    {
			 return Department::withTrashed()->where($this->search_data)->get();
    }
    public function headings(): array
    		{
        		return
         		[
      				 'id',
      				'department_name',
        			'deleted_at',
        			'created_at',
        			'updated_at'
       			];
    		}


    	public function title(): string
    		{

    			return 'Departments';
    		}
}
