<div class="dropdown">
    <button 
        class="btn btn-default dropdown-toggle"
        type="button" 
        id="dropdownMenu-{{ phrase.id }}" 
        data-toggle="dropdown" 
        aria-haspopup="true" 
        aria-expanded="false">
        Options <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="{{ url('phrases/toggleCase?id=' ~ phrase.id) }}">Flip Case Sensitivity</a>
        </li>
        <li>
            <a href="{{ url('phrases/delete?id=' ~ phrase.id) }}">Delete</a>
        </li>
    </ul>
</div>
