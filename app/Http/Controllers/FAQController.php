<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateFAQRequest;
use App\Http\Requests\UpdateFAQRequest;
use App\Repositories\FAQRepository;
use App\DataTables\FAQDataTable;
use Illuminate\Http\Request;
use App\Models\FAQ;
use Response;
use Flash;

class FAQController extends Controller
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
    public function index(FAQDataTable $faqDataTable)
    {
        return $faqDataTable->render('faqs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFAQRequest $request)
    {
        $input = $request->all();

        $faq = $this->FAQRepository->create($input);

        Flash::success('FAQ saved successfully.');

        return redirect(route('faqs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faq = $this->FAQRepository->find($id);

        if (empty($faq)) {
            Flash::error('FAQ not found');

            return redirect(route('faqs.index'));
        }

        return view('faqs.show')->with('faq', $faq);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq = $this->FAQRepository->find($id);

        if (empty($faq)) {
            Flash::error('FAQ not found');

            return redirect(route('faqs.index'));
        }

        return view('faqs.edit')->with('faq', $faq);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateFAQRequest $request)
    {
        $faq = $this->FAQRepository->find($id);

        if (empty($faq)) {
            Flash::error('FAQ not found');

            return redirect(route('faqs.index'));
        }

        $faq = $this->FAQRepository->update($request->all(), $id);

        Flash::success('FAQ updated successfully.');
        
        return redirect(route('faqs.index'));
    }

    public function showFAQ( Request $request)
    {   
        
        $faqs = FAQ::where('type', 'faq')->paginate(10);
    
        return view('faq',compact('faqs'));
    }

    public function showHelp()
    {
        $helps = FAQ::where('type', 'help')->paginate(10);
        return view('help', compact('helps'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = $this->FAQRepository->find($id);

        if (empty($faq)) {
            Flash::error('FAQ not found');

            return redirect(route('faqs.index'));
        }

        $this->FAQRepository->delete($id);

        Flash::success('FAQ deleted successfully.');

        return redirect(route('faqs.index'));
    }
}
