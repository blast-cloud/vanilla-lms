<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFAQAPIRequest;
use App\Http\Requests\API\UpdateFAQAPIRequest;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\FAQResource;
use App\Http\Requests\CreateFAQRequest;
use App\Http\Requests\UpdateFAQRequest;
use App\Repositories\FAQRepository;
use App\DataTables\FAQDataTable;
use Illuminate\Http\Request;
use App\Models\FAQ;
use Response;

class FAQAPIController extends AppBaseController
{
    /** @var  FAQRepository */
    private $FAQRepository;

    public function __construct(FAQRepository $FAQRepo)
    {
        $this->FAQRepository = $FAQRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = $this->FAQRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(FAQResource::collection($faqs), 'FAQs retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(CreateFAQAPIRequest $request)
    {
        $input = $request->all();

        $faq = $this->FAQRepository->create($input);
        
        return $this->sendResponse(new FAQResource($faq), 'FAQ saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faq = FAQ::find($id);

        if (empty($faq)) {
            return $this->sendError('FAQ not found');
        }

        //dd($faq);

        return $this->sendResponse($faq, 'FAQ retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFAQAPIRequest $request, $id)
    {
        $input = $request->all();

        /** @var Department $department */
        $faq = FAQ::find($id);

        if (empty($faq)) {
            return $this->sendError('FAQ not found');
        }

        $faq = $this->FAQRepository->update($input, $id);

        return $this->sendResponse($faq, 'FAQ updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = $this->FAQRepository->find($id);

        if (empty($faq)) {
            return $this->sendError('FAQ not found');
        }

        $faq->delete();
        return $this->sendSuccess('FAQ deleted successfully');
    }
}
