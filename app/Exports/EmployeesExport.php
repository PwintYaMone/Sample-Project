<?php

namespace App\Exports;
use Illuminate\Http\Request;
use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;



    /**Display employee export , Collection , Heading ,Title, AfterSheet
    *@author Pwint Ya Mone
    *@date 28/08/2020
    * @return \Illuminate\Support\Collection
    */


class EmployeesExport implements FromCollection,WithHeadings, WithTitle, WithEvents
{
   
    
    		protected  $search_data;
    
    		public function __construct(  $search_data)

    		{
        		$this->search_data=  $search_data;
            //dd($this->search_data);
   			}

   			public function collection()

    		{	    
          
          return   $employees = DB::table('employees')
            ->join('emp__dep__positions', 'emp__dep__positions.employee_id', '=', 'employees.id')
            ->join('departments', 'emp__dep__positions.department_id', '=', 'departments.id')
            ->join('positions', 'emp__dep__positions.position_id', '=', 'positions.id')
            ->select('employees.*', 'departments.department_name', 'positions.position_name')
            ->where($this->search_data)
            ->get();

    		}
    	 public function headings(): array

    		{
        		return
         		[
      				  'id',
      				  'employee_name',
      				  'email',
        				'dob',
        				'password',
        				'gender',
        				'deleted_at',
        				'created_at',
        				'updated_at',
                'department_name',
                'position_name',
               
       			];
    		}


    	public function title(): string

    		{

    			return 'Employees';

    		}

    /**Display Excel Heading color and font
    *@author Pwint Ya Mone
    *@date 31/08/2020
    * @return \Illuminate\Support\Collection
    */

      use RegistersEventListeners;
      public static function afterSheet(AfterSheet $event)
      {
           
        $sheet = $event->sheet->getDelegate();
        $sheet->getStyle('A1:K1')->getFont()->setSize(14);
        $sheet->getStyle('A1:K1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('00CC33');
      }
   



    

}
