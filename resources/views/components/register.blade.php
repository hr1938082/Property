
<div class="row justify-content-center align-items-center m-0" id="register">
        <div class="col-lg-3 col-md-4 col-sm-6 col-10 shadow-lg p-0 form active">

            <div class="col-12 d-flex bg-primary justify-content-center text-white align-items-center head">
                <h1 class="font-weight-lighter">{{$heading}}</h1>
            </div>
            <div class="col-12 py-3 bg-white">
                <form action="{{ route('useradd') }}" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control
                            @if ($errors->any())
                                @error('name')
                                    {{"is-invalid"}}
                                @enderror
                            @endif
                        "placeholder="Name" name="name"  id="name" />
                        @if ($errors->any())
                            @error('name')
                            <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        @endif
                        @csrf
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control
                            @if ($errors->any())
                                @error('email')
                                    {{"is-invalid"}}
                                @enderror
                            @endif
                            {{$email ? 'is-invalid' : ''}}
                        " placeholder="Email" name="email"  id="email" />
                        @if ($errors->any())
                            @error('email')
                            <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        @endif
                        @if ($email != null)
                            <span class="invalid-feedback">{{$email}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control
                            @if ($errors->any())
                                @error('password')
                                    {{"is-invalid"}}
                                @enderror
                            @endif
                        " placeholder="Password" name="password"  id="password" />
                        @if ($errors->any())
                            @error('password')
                            <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="select">User Type</label>
                        <select name="user_type_id" id="user_type_id" class="form-control
                                @if ($errors->any())
                                    @error('user_type_id')
                                        {{"is-invalid"}}
                                    @enderror
                                @endif
                        ">
                            <option selected disabled>User Type</option>
                            @if ($users->count() > 0)
                                @foreach ($users as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->any())
                            @error('user_type_id')
                            <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        @endif
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">Submit</button>
                </form>
            </div>
        </div>
</div>
