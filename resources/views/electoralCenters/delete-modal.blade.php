@foreach ($electoralCenters as $electoralCenter)
    <div class="modal fade" id="deleteModal{{$electoralCenter->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalExample">هل تريد حذف مركز الإقتراع</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body text-right">اختر "حذف" بالأسفل اذا كنت تريد حذف. <span class="text-danger">{{$electoralCenter->ec_name}}</span> مركز الإقتراع!.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">إلغاء</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('electoralCenter-delete-form{{$electoralCenter->id}}').submit();">
                        حذف
                    </a>
                    <form id="electoralCenter-delete-form{{$electoralCenter->id}}" method="POST" action="{{ route('electoralCenters.destroy', ['electoralCenter' => $electoralCenter->id]) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


