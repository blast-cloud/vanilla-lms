@extends('layouts.app')


@section('title_postfix')
FAQs and Help
@stop

@section('page_title')
FAQs and Help
@stop


@section('content')
    
    @include('flash::message')

    <div class="col-sm-9">
        <div class="panel panel-default card-view">

            <div class="panel-heading" style="padding: 10px 15px;">
                <div class="pull-left"></div>
                <div class="pull-right">
                    <a id="btn-new-mdl-faq-modal" href="#" class="btn btn-xs btn-default btn-new-mdl-faq-modal"><i class="zmdi zmdi-help"></i>&nbsp;Add FAQ or Help</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <div class="container">
                      <h1>Frequently asked questions</h1>
                      <div class="faq-container">
                      @foreach($faqs as $faq)
                        <div class="faq">
                          <h3 class="faq-title">{{ $faq->question }}?</h3>
                          <p class="faq-text">{{ $faq->answer }}</p>
                          <button class="faq-toggle">
                            <i class="fa fa-chevron-down"></i>
                          </button>
                        </div>
                      @endforeach
                  
                      </div>
                    </div>

                </div>
              </div>
      <script type="text/javascript">
        const toggles = document.querySelectorAll(".faq-toggle");
        toggles.forEach((toggle) => {
          toggle.addEventListener("click", () => {
            toggle.parentNode.classList.toggle("active");
          });
        });
      </script>
        </div>
    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
    </div>
@endsection



