{% extends "_templates/basic.volt" %}
{% block body_attributes %} id="signin"{% endblock %}
{% block body %}

    <a href="{{ url('') }}" class="logo">
        <i class="brankic-pen"></i>
    </a>

    <h3>Welcome back!</h3>

    <div class="content">

        {% include "_templates/flashMessages.volt" %}

        <div class="header">
            <a href="index" class="logo">
                <img src="{{ url('spacial/images/logo-alt-b.png') }}" />
            </a>
        </div>

        {{ form('register/do', 'method' : 'post') }}

        <div class="fields">
            {{ form.label('email') }}
            {{ form.render('email') }}
        </div>

        <div class="fields">
            {{ form.label('password') }}
            {{ form.render('password') }}
        </div>

        <div class="fields">
            {{ form.label('password_confirmation') }}
            {{ form.render('password_confirmation') }}
        </div>

        <div class="actions">
            {{ form.render('submit') }}
        </div>

        {{ endform() }}
    </div>

    <div class="bottom-wrapper">
        <div class="message">
            <a href="{{ url('login') }}">Would you like to login instead?</a>
        </div>
    </div>

{% endblock %}

