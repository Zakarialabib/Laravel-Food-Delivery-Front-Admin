@extends('layouts.landing.app')

@section('title','Landing Page | '.\App\Models\BusinessSetting::where(['key'=>'business_name'])->first()->value??'Stack TIKTAK')

@section('content')

    <main>
        @php($front_end_url=\App\Models\BusinessSetting::where(['key'=>'front_end_url'])->first())
        @php($front_end_url=$front_end_url?$front_end_url->value:null)

        @php($landing_page_text = \App\Models\BusinessSetting::where(['key'=>'landing_page_text'])->first())
        @php($landing_page_text = isset($landing_page_text->value)?json_decode($landing_page_text->value, true):null)
        
        @php($landing_page_links = \App\Models\BusinessSetting::where(['key'=>'landing_page_links'])->first())
        @php($landing_page_links = isset($landing_page_links->value)?json_decode($landing_page_links->value, true):null)

        @php($landing_page_images = \App\Models\BusinessSetting::where(['key'=>'landing_page_images'])->first())
        @php($landing_page_images = isset($landing_page_images->value)?json_decode($landing_page_images->value, true):null)
        <div class="main-body-div">
            <!-- Top Start -->
            <section class="top-start">
                <div class="container ">
                    <div class="row">
                        <div class="row col-lg-7 top-content">
                            <div>
                                <h3 class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    {{isset($landing_page_text)?$landing_page_text['header_title_1']:''}}
                                </h3>
                                <span
                                    class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    {{isset($landing_page_text)?$landing_page_text['header_title_2']:''}}
                                </span>
                                <h4 class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    {{isset($landing_page_text)?$landing_page_text['header_title_3']:''}}
                                </h4>
                            </div>

                            <div class="download-buttons">
                                @if($landing_page_links['app_url_android_status'])
                                <div class="play-store">
                                    <a href="{{$landing_page_links['app_url_android']}}">
                                        <img src="{{asset('public/assets/landing')}}/image/play_store.png">
                                    </a>
                                </div>
                                @endif
                                @if($landing_page_links['app_url_ios_status'])
                                <div class="apple-store">
                                    <a href="{{$landing_page_links['app_url_ios']}}">
                                        <img src="{{asset('public/assets/landing')}}/image/apple_store.png">
                                    </a>
                                </div>
                                @endif
                                @if($landing_page_links['web_app_url_status'])
                                <div class="apple-store">
                                    <a href="{{$landing_page_links['web_app_url']}}">
                                        <img src="{{asset('public/assets/landing')}}/image/browse.png">
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div
                            class="col-lg-5 d-flex justify-content-center justify-content-md-end text-center text-md-right top-image">
                            <img src="{{asset('public/assets/landing')}}/image/{{isset($landing_page_images)?$landing_page_images['top_content_image']:'double_screen_image.png'}}">
                        </div>
                    </div>
                </div>
            </section>
            <!-- Top End -->

            <!-- About Us Start -->
            <section class="about-us">
                <div class="container">
                    <div class="row featured-section">
                        <div class="col-12 featured-title-m">
                            <span>{{__('about_us')}}</span>
                        </div>
                        <div
                            class="col-lg-6 col-md-6  d-flex justify-content-center justify-content-md-start text-center text-md-left featured-section__image">
                            <img src="{{asset('public/assets/landing')}}/image/{{isset($landing_page_images)?$landing_page_images['about_us_image']:'about_us_image.png'}}"></img>
                        </div>
                        <!-- <div class="col-lg-3 col-md-0"></div> -->
                        <div class="col-lg-6 col-md-6">
                            <div class="featured-section__content"
                                 class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                <span>{{__('about_us')}}</span>
                                <h2
                                    class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    {{isset($landing_page_text)?$landing_page_text['about_title']:''}}</h2>
                                <p
                                    class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    {!! \Illuminate\Support\Str::limit(\App\CentralLogics\Helpers::get_settings('about_us'),200) !!}
                                </p>
                                <div 
                                    class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    <a href="{{route('about-us')}}"
                                       class="btn btn-color-primary text-white rounded align-middle">{{__('read_more')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- About Us End -->

            <!-- Why Choose Us Start -->
            @php($speciality = \App\Models\BusinessSetting::where(['key'=>'speciality'])->first())
            @php($speciality = isset($speciality->value)?json_decode($speciality->value, true):null)
            @if(isset($speciality) && count($speciality)>0)
            <section class="why-choose-us">
                <div class="container">
                    <div class="row choosing-section">
                        <div class="choosing-section__title">
                            <div>
                                <h2>{{isset($landing_page_text)?$landing_page_text['why_choose_us']:''}}</h2>
                                <span>{{isset($landing_page_text)?$landing_page_text['why_choose_us_title']:''}}</span>
                                <hr class="customed-hr-1">
                            </div>
                        </div>
                        <div class="choosing-section__content">
                        @foreach ($speciality as $sp)
                            <div>
                                <div class="choosing-section__image-card">
                                    <img src="{{asset('public/assets/landing')}}/image/{{$sp['img']}}"></img>
                                </div>
                                <div style="margin: 0px 55px 30px 54px">
                                    <p>{{$sp['title']}}</p>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>

            </section>
            @endif
            <!-- Why Choose Us End -->
            @php($testimonial = \App\Models\BusinessSetting::where(['key'=>'testimonial'])->first())
            @php($testimonial = isset($testimonial->value)?json_decode($testimonial->value, true):null)
            <!-- Trusted Customers Starts -->
            @if($testimonial && count($testimonial)>0)
            <section class="trusted-customers">
                <div class="container">
                    <div class="trusted_customers__title">
                        <span class="trusted-customer mt-4" style="font-size: 33px">{{isset($landing_page_text)?$landing_page_text['testimonial_title']:''}}</span>
                    </div>

                    <div class="mt-5">
                        <div class="demo">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="testimonial-slider" class="owl-carousel">
                                            @foreach($testimonial as $data)
                                                <div class="testimonial">
                                                    <div class="pic">
                                                        <img src="{{asset('public/assets/landing')}}/image/{{$data['img']}}"
                                                             alt="">
                                                    </div>
                                                    <div class="testimonial-content">
                                                        <h3 class="testimonial-title">
                                                            {{$data['name']}}
                                                            <small class="post">{{$data['position']}}</small>
                                                        </h3>
                                                        <p class="description">
                                                           {{$data['detail']}}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif
            <!-- Trusted Customers Ends -->
        </div>
    </main>

@endsection
