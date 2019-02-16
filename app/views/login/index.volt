{% extends "_templates/basic.volt" %}
{% block body_attributes %} id="signin"{% endblock %}
{% block body %}

    <h3>&nbsp;</h3>

    <div class="content">
        
        {% include "_templates/flashMessages.volt" %}

        <div class="header">
            <h4>Login</h4>
        </div>
            
        {{ form('login/do', 'method' : 'post') }}

        <div class="fields">
            {{ form.label('email') }}
            {{ form.render('email') }}
        </div>

        <div class="fields">
            {{ form.label('password') }}
            {{ form.render('password') }}
        </div>

        <div class="actions">
            {{ form.render('submit') }}
        </div>

        {{ endform() }}
    </div>

    <div class="bottom-wrapper">
        <div class="message">
            <a href="{{ url('register') }}">Sign up</a>
        </div>
    </div>

{% endblock %}

