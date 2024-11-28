<x-layout>
    <x-slot:heading>
        Register
    </x-slot:heading>

    <form method="POST" action="/register">
        @csrf <!--inserts hidden input with token, without it returns 419 expired error-->
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">


                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <x-form-field>
                        <x-form-label for="first_name">First Name</x-form-label>
                        <div class="mt-2">

                            <x-form-input name="first_name" id="first_name" autocomplete="first_name" required></x-form-input>

                            <x-form-error name="first_name" />
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="last_name">
                            Last Name
                        </x-form-label>
                        <div class="mt-2">
                            <x-form-input name="last_name" id="last_name" value="{{ old('last_name') }}" autocomplete="last_name" required></x-form-input>
                            {{--o   ld() to keep last name if form if validation fails, you can also use :value="old('last_name') to read it as code, not as a string --}}
                            <x-form-error name="last_name" />
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="email">
                            Email
                        </x-form-label>
                        <div class="mt-2">
                            <x-form-input name="email" id="email" type="email" autocomplete="email" required></x-form-input>
                            <x-form-error name="email" />
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="password">
                            Password
                        </x-form-label>
                        <div class="mt-2">
                            <x-form-input name="password" id="password" type="password" autocomplete="password" required></x-form-input>
                            <x-form-error name="password" />
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="password_confirmation">
                            Confirm Password
                        </x-form-label>
                        <div class="mt-2">
                            <x-form-input name="password_confirmation" id="password_confirmation" type="password" autocomplete="password_confirmation" required></x-form-input>
                            <x-form-error name="password_confirmation" />
                        </div>
                    </x-form-field>

                </div>
            </div>
        </div>


        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="/" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
            <x-form-button>Register</x-form-button>
        </div>
    </form>

</x-layout>
