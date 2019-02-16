<div class="dropdown">
    <button 
        class="btn btn-default dropdown-toggle"
        type="button" 
        id="dropdownMenu-{{ pdf.id }}" 
        data-toggle="dropdown" 
        aria-haspopup="true" 
        aria-expanded="false">
        Options <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="{{ pdf.url }}">View PDF</a>
        </li>
        <li>
            <a href="{{ url('pdfs/delete?id=' ~ pdf.id) }}">Delete</a>
        </li>
    </ul>
</div>
