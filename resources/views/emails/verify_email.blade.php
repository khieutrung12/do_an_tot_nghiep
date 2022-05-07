@component('mail::message')
    <h2 style="text-align: center;">
        Hello, {{ Auth()->user()->name }}
    </h2>
    <p style="text-align: center;">
        You have registered an account in our system,
    </p>
    <p style="text-align: center;">
        To be able to continue using the services, please click the confirmation button below to activate your account.
    </p>
    <div style="text-align: center;">
        <a  href="{{ route('admin.active.email', [
                        'id' => Auth()->user()->id,
                        'token' => Auth()->user()->token, ]) }}"
                style="display: inline-block;
                        background-color: #313A46;
                        color: white;
                        box-shadow: 1px 0 3px rgba(0, 0, 0, 0.15);
                        border-radius: 4px;
                        border: 2px solid #313A46;
                        padding: 5px;
                        margin-top: 5px;
                        cursor: pointer;
                        text-decoration: none;">
                Verify
        </a>
    </div>
@endcomponent
