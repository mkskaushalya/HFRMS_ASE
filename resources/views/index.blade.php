<x-default-layout>
    <section id="hero">
        <div class="cont">
            <div class="hero-content">
                <h1>Find the best place for you</h1>
                <p>Find the best halls for you and book now</p>
                <div class="search-form">
                    <form action="{{ route('halls') }}" method="GET">
                        <div class="input-box">
                            <label for="location">Location</label>
                            <select name="location" id="location">
                                @foreach($locations as $location )
                                    <option
                                        value="{{ $location->id }}">{{ $location->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-box">
                            <label for="booking_date">Date</label>
                            <input type="date"
                                   min="{{ today()->format("Y-m-d") }}"
                                   name="booking_date" id="booking_date" placeholder="Select Date">
                        </div>
                        <div class="input-box">
                            <label for="start_time">Start Time</label>
                            <input type="time"
                                   name="start_time" id="start_time" placeholder="Select Time">
                        </div>
                        <div class="input-box">
                            <label for="end_time">End Time</label>
                            <input type="time"
                                   name="end_time" id="end_time" placeholder="Select Time">
                        </div>

                        <div class="input-box">
                            <button type="submit">Search</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section>

    <section id="halls">
        <div class="cont">
            <div class="heading">
                <h2>Our Halls</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, incidunt?</p>
            </div>
            <div class="hall-card-list">
                <div class="swiper hallSwiper">
                    <div class="swiper-wrapper">
                        @foreach($halls as $hall)
                            <a class="hall-card swiper-slide" href="{{ route('halls.show', $hall) }}">
                                <div class="hall-image">
                                    <img src="{{ $hall->image }}" alt="{{ $hall->name }}">
                                </div>
                                <div class="hall-title">
                                    <h3>{{ $hall->name }}</h3>
                                    <p>{{ $hall->description }}</p>
                                </div>
                                <div class="ratings">
                                    @php($ratingAvg = number_format($hall->reviews->avg('rating'), 1, '.', '') )

                                    <span class="rate">{{ $ratingAvg }}</span><span class="rate-text">@if($ratingAvg == 5)
                                            Excellent
                                        @elseif($ratingAvg >= 4)
                                            Very Good
                                        @elseif($ratingAvg >= 3)
                                            Average
                                        @elseif($ratingAvg >= 2)
                                            Poor
                                        @elseif($ratingAvg >= 1)
                                            Terrible
                                        @else
                                            No Rating
                                        @endif</span>
                                    <span class="num-rate">{{ $hall->reviews->count() }} Reviews</span>
                                </div>
                                <div class="hall-features">
                                    <p>Price : <span>LKR {{ $hall->price }}</span> / Hour</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                </div>

            </div>

        </div>
        <div class="swiper-button-next hall-swiper-next"></div>
        <div class="swiper-button-prev hall-swiper-prev"></div>
        <div class="swiper-pagination"></div>

    </section>
    <section id="hall-reviews" class="homepage">
        <div class="cont">
            <div class="heading">
                <h2>Customer Reviews</h2>
            </div>
            <div class="reviews">
                <div class="left">
                    <h3>What our customers are saying us?</h3>
                    <p>Read the reviews from our customers and know about their experience</p>
                    <div class="all-count-review">
                        <div class="count-review">
                            <h3>{{ $review_count }}</h3>
                            <p>Total Reviews</p>
                        </div>
                        <div class="count-review">
                            <h3>{{ number_format($reviews->avg('rating'), 1, '.', '') }}</h3>
                            <p>Average Rating</p>
                        </div>
                    </div>

                </div>
                <div class="right">
                    <div class="review-list homepage-reviews" id="review-list">
                        <div class="swiper reviewSwiper">
                            <div class="swiper-wrapper">
                                @foreach($reviews->reverse() as $review)
                                    <div class="review swiper-slide" id="review-{{ $review->id }}">
                                        <div class="details">
                                            @if(Auth::check() && (Auth::user()->id == $review->user_id || Auth::user()->usertype == 'admin'))
                                                <div class="action-btn-sec">
                                                    <div class="icon-3-btn">
                                                        <span class="dot-icon"></span><span
                                                            class="dot-icon"></span><span
                                                            class="dot-icon"></span>
                                                    </div>
                                                    <ul class="action-dropdown">
                                                        <li>
                                                            <a href="{{ route('halls.reviews', [$hall, $review]) }}"
                                                               class="action-drop-btn-edit review_action_edit"
                                                               data_review_id="{{ $review->id  }}"
                                                               data_review_form_action="{{ route('halls.reviews.update', [$hall, $review]) }}"
                                                               data_review_title="{{ $review->title  }}"
                                                               data_review_message="{{ $review->message  }}"
                                                               data_review_rating="{{ $review->rating  }}"
                                                            >Edit</a>
                                                        </li>
                                                        <li>
                                                            <button type="submit"
                                                                    form="reviewDeleteForm-{{ $review->id }}"
                                                                    onclick="return confirm('Are you sure you want to delete this review?')"
                                                                    class="action-drop-btn-delete">Delete
                                                            </button>
                                                            <form
                                                                id="reviewDeleteForm-{{ $review->id }}"
                                                                action="{{ route('halls.reviews.destroy', [$hall, $review]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="left">
                                                <img src="{{url($review->user->profile_picture)}}" alt="User Image">
                                            </div>
                                            <div class="right">
                                                <h3>{{$review->user->firstname}} {{$review->user->lastname}}</h3>
                                                <p>{{$review->created_at->format('d/m/Y h:s A')}}</p>
                                            </div>
                                        </div>
                                        <div class="title"><h3>{{$review->title}}</h3></div>
                                        <div class="message">
                                            <p>{{$review->message}}</p>
                                        </div>
                                        <div class="star-rating">
                                            <div class="stars">
                                                @for($i = 0; $i < $review->rating; $i++)
                                                    <div class="star">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                            <path
                                                                d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                                                        </svg>
                                                    </div>
                                                @endfor
                                                @for($i = 0; $i < 5 - $review->rating; $i++)
                                                    <div class="star">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                            <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                            <path
                                                                d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"/>
                                                        </svg>
                                                    </div>
                                                @endfor


                                            </div>
                                            ({{$review->rating}}/5)
                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</x-default-layout>
