@foreach ($individuals as $individual)
    <div class="modal fade" id="deleteModal{{$individual->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalExample">هل تريد حذف الفرد</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body text-right">اختر "حذف" بالأسفل اذا كنت تريد حذف. <span class="text-danger">{{$individual->i_name}}</span> الفرد!.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">إلغاء</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('individual-delete-form{{$individual->id}}').submit();">
                        حذف
                    </a>
                    <form id="individual-delete-form{{$individual->id}}" method="POST" action="{{ route('individuals.destroy', ['individual' => $individual->id]) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


