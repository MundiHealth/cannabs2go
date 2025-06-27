<section class="account-area white-bg border-top pt-60 pb-60">
    <div class="container">
{{--        <div class="row">--}}
            <div class="account-content">

                @include('shop::customers.account.partials.sidemenu')

                <div class="account-layout">

                    <div class="account-head">

                        <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>

                        <span class="account-heading">{{ __('shop::app.customer.account.profile.index.title') }}</span>

                        <span class="account-action">
                <a href="{{ route('customer.profile.edit') }}">{{ __('shop::app.customer.account.profile.index.edit') }}</a>
            </span>

                        <div class="horizontal-rule"></div>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.before', ['customer' => $customer]) !!}

                    <div class="account-table-content" style="width: 50%;">
                        <table style="color: #5E5E5E;">
                            <tbody>
                            <tr>
                                <td><b>{{ __('shop::app.customer.account.profile.fname') }}</b></td>
                                <td>{{ $customer->first_name }}</td>
                            </tr>

                            <tr>
                                <td><b>{{ __('shop::app.customer.account.profile.lname') }}</b></td>
                                <td>{{ $customer->last_name }}</td>
                            </tr>

                            <tr>
                                <td><b>{{ __('shop::app.customer.account.profile.gender') }}</b></td>

                                @if($customer->gender == 'Female')
                                    @php($gender = __('admin::app.customers.customers.female'))
                                @elseif($customer->gender == 'Male')
                                    @php($gender = __('admin::app.customers.customers.male'))
                                @elseif($customer->gender == 'Other')
                                    @php($gender = __('admin::app.customers.customers.other'))
                                @else
                                    @php($gender = '')
                                @endif
                                <td>{{ $gender }}</td>
                            </tr>

                            <tr>
                                <td><b>{{ __('shop::app.customer.account.profile.dob') }}</b></td>
                                <td>{{ $customer->date_of_birth }}</td>
                            </tr>

                            <tr>
                                <td><b>{{ __('shop::app.customer.account.profile.email') }}</b></td>
                                <td>{{ $customer->email }}</td>
                            </tr>

                            {{-- @if ($customer->subscribed_to_news_letter == 1)
                                <tr>
                                    <td> {{ __('shop::app.footer.subscribe-newsletter') }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('shop.unsubscribe', $customer->email) }}">{{ __('shop::app.subscription.unsubscribe') }} </a>
                                    </td>
                                </tr>
                            @endif --}}
                            </tbody>
                        </table>
                    </div>

{{--                    <accordian :title="'{{ __('shop::app.customer.account.profile.index.title') }}'" :active="true">--}}
{{--                        <div slot="body">--}}
{{--                            <div class="page-action">--}}
{{--                                <button type="submit" @click="showModal('deleteProfile')" class="btn btn-lg btn-primary mt-10">--}}
{{--                                    {{ __('shop::app.customer.account.address.index.delete') }}--}}
{{--                                </button>--}}
{{--                            </div>--}}

{{--                            <form method="POST" action="{{ route('customer.profile.destroy') }}" @submit.prevent="onSubmit">--}}
{{--                                @csrf--}}
{{--                                <modal id="deleteProfile" :is-open="modalIds.deleteProfile">--}}
{{--                                    <h3 slot="header">{{ __('shop::app.customer.account.address.index.enter-password') }}</h3>--}}

{{--                                    <div slot="body">--}}
{{--                                        <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">--}}
{{--                                            <label for="password" class="required">{{ __('admin::app.users.users.password') }}</label>--}}
{{--                                            <input type="password" v-validate="'required|min:6|max:18'" class="control" id="password" name="password" data-vv-as="&quot;{{ __('admin::app.users.users.password') }}&quot;"/>--}}
{{--                                            <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>--}}
{{--                                        </div>--}}

{{--                                        <div class="page-action">--}}
{{--                                            <button type="submit"  class="btn btn-lg btn-primary mt-10">--}}
{{--                                                {{ __('shop::app.customer.account.address.index.delete') }}--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </modal>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </accordian>--}}

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.after', ['customer' => $customer]) !!}
                </div>
            </div>
{{--        </div>--}}
    </div>
</section>
