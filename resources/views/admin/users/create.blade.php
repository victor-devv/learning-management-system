@extends('templates.main')

@section('css')

<!-- MULTI SELECT TOOL -SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<h1>Add User</h1>
<br>
<br>
<div class="card authform">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @include('admin.users.partials.form')
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- MULTI SELECT TOOL -SELECT2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    $(document).ready(() => {
        $(".roles-selector").select2({
            tags: true
        });

        $('#role4').click(function() {
            console.log('a');
            if ($("#roles option[value=4]:selected").length > 0) {
                console.log('b');

                $('#mentorSection').attr('hidden', false);

            } else {

                $('#mentorSection').attr('hidden', true);

            }
        });

        $('#roles').on('change', function() {
            // var first = $(this).find('option').first().val();
            // var none = $(this).find('option:selected').length;
                        // $(this).val() == 4
            let selectObject = $('#roles').select2('data');

            let found = false;

            if (selectObject === undefined || selectObject.length == 0) {
                $('#mentorSection').attr('hidden', true);
            }

            for(var i = 0; i < selectObject.length; i++) {
                if (selectObject[i].text == 'Student') {
                    found = true;
                    $('#mentorSection').attr('hidden', false);
                    break;
                } else{
                    // console.log(found);
                    $('#mentorSection').attr('hidden', true);
                }
            }

            
        });
    });
</script>
@endsection