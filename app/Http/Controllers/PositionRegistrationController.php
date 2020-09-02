<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PositionRegistrationRequest;
use App\Repositories\Interfaces\PositionRepositoryInterface;


class PositionRegistrationController extends Controller
{
	public function __construct(PositionRepositoryInterface $positionRepo)
    {       
        $this->positionRepo = $positionRepo;

    }
    public function save(PositionRegistrationRequest $request)
    {
    	$this->positionRepo->savePosition($request);


    }
    

 }
