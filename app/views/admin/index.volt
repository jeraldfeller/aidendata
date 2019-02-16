{% extends "_templates/basic.volt" %}
{% block body_attributes %} id="latest-activity"{% endblock %}
{% block body %}

    <div id="wrapper">
        {% include "_templates/navigation.volt" %}

        <div id="content">

            <div class="panel">

                <div class="menubar">
                    <div class="sidebar-toggler visible-xs">
                        <i class="ion-navicon"></i>
                    </div>

                    <div class="page-title">
                        Home
                    </div>

                </div>

                <div class="content-wrapper">

                    <div class="text-center">
                        {% include "_templates/customPagination.volt" %}
                    </div>


                    {% for pdf in pdfs %}

                        <div class="moment{% if loop.first %} first{%endif %}">
                            <div class="row event clearfix">
                                <div class="col-sm-1">
                                    <div class="icon">
                                        <i class="fa fa-comment"></i>
                                    </div>
                                </div>
                                <div class="col-sm-11 message">
                                    {% if pdf.ScrapeSource.image is not null %}
                                        <img class="avatar" src="{{ url('images/council/' ~ pdf.ScrapeSource.image) }}">
                                    {% endif %}
                                    <div class="content">
                                        <strong>{{ pdf.ScrapeSource.name }}</strong> has uploaded 
                                        <a href="{{ url('pdfs/view?id=' ~ pdf.id) }}">{{ pdf.getFileName() }}</a> 
                                        containing<strong> {{ pdf.matches.count() }} phrases</strong> 
                                        {% if pdf.last_checked is not null %}
                                            <time class="timeago text-muted small" datetime="{{ parseMySqlDateTime(pdf.last_checked).format('c') }}">
                                                {{ pdf.last_checked }}
                                            </time>
                                        {% endif %}

                                        <p class="border-bottom">
                                            {% for match in pdf.matches %}
                                                <span class="btn btn-sm btn-default">{{ match.Phrase.text }} (Page {{ match.page }})</span>
                                            {% endfor %}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {% endfor %}

                    <div class="text-center">
                        {% include "_templates/customPagination.volt" %}
                    </div>

                </div>

            </div>

        </div>
    </div>

{% endblock %}
