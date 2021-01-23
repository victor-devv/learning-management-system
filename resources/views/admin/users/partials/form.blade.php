@csrf

<div class="mb-3">
    <label for="first-name" class="form-label">First Name</label>
    <input type="text" class="form-control @error('first-name') is-invalid @enderror" id="first-name" name="first-name" value="{{ isset($user) ? $user->first_name : old('first-name') }}">
    @error('first-name')
    <span class="invalid-feedback" role="alert">
        {{ $message }}
    </span>
    @enderror
</div>

<div class="mb-3">
    <label for="last-name" class="form-label">Last Name</label>
    <input type="text" class="form-control @error('last-name') is-invalid @enderror" id="last-name" name="last-name" value="{{ isset($user) ? $user->last_name : old('last-name') }}">
    @error('last-name')
    <span class="invalid-feedback" role="alert">
        {{ $message }}
    </span>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ isset($user) ? $user->email : old('email') }}">
    @error('email')
    <span class="invalid-feedback" role="alert">
        {{ $message }}
    </span>
    @enderror
</div>

@if(!isset($user))
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
    @error('password')
    <span class="invalid-feedback" role="alert">
        {{ $message }}
    </span>
    @enderror
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
    @error('password_confirmation')
    <span class="invalid-feedback" role="alert">
        {{ $message }}
    </span>
    @enderror
</div>
@endif

<div class="mb-3">
    <label for="roles">Role(s)</label>
    <select name="roles[]" id="roles" class="form-control roles-selector" multiple>

        @foreach($roles as $role)
        <option id="role{{ $role->id }}" value="{{ $role->id }}" @if(isset($user)) @if($user->hasRole($role->id))
            selected
            @endif
            @endif
            >{{ $role->name }}</option>

        @endforeach

    </select>
</div>

<div class="mb-3" hidden id="mentorSection">
    <label for="mentor">Mentor</label>
    <select name="mentor" id="mentor" class="form-control mentor-selector">
        @if(isset($mentee))
        @foreach($mentors as $mentor)
        <option value="{{ $mentor->id }}" @if($mentor->id === $mentee->mentor_id)
            selected
            @endif
            >{{ $mentor->first_name }} {{ $mentor->last_name }}</option>
        @endforeach

        @else
        <option value="" disabled selected>Select Mentor</option>
        @foreach($mentors as $mentor)
        <option value="{{ $mentor->id }}">{{ $mentor->first_name }} {{ $mentor->last_name }}</option>
        @endforeach
        @endif
    </select>
</div>


<button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update User' : 'Create User' }}</button>