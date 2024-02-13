<div class="card">
    <div class="card-body">
        <ul class="mail-folders">
            <li>
                <a class=" btn btn-outline-primary {{request()->routeIs('user-fetch-mail-folders') || request()->routeIs('single-mail') ? 'active' : '' }}" href="{{route('user-fetch-mail-folders',[$mail_id])}}">
                    <i class='bx bxs-inbox menu-icon'></i>
                    Inbox <span class="badge">{{$totalMessage}}</span></a>
            </li>
            <li>
                <a class="btn btn-outline-primary" href="">
                    <i class='bx bx-edit-alt menu-icon' ></i>
                    Draft</a>
            </li>
            <li>
                <a class="btn btn-outline-primary" href="">
                    <i class='bx bx-send menu-icon'></i>
                    Sent Mail</a>
            </li>
            <li>
                <a href="" class="btn btn-outline-primary">
                    <i class='bx bx-trash menu-icon' ></i>
                    Trash</a>
            </li>
        </ul>
    </div>
</div>
