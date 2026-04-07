<script>
    document.querySelector('[data-bs-target="#previewModal"]').addEventListener('click', () => {
        document.getElementById('previewTitle').innerText =
            document.querySelector('[name="title"]').value;

        document.getElementById('previewCompany').innerText =
            document.querySelector('[name="company_name"]').value;

        document.getElementById('previewMeta').innerText =
            document.querySelector('[name="location"]').value + ' · ' +
            document.querySelector('[name="job_type"]').value;

        // CKEditor content
        document.getElementById('previewDescription').innerHTML =
            CKEDITOR.instances['descriptionEditor'].getData();
    });
</script>



<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Job Preview</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <h4 id="previewTitle"></h4>
                <p class="fw-semibold" id="previewCompany"></p>
                <p class="text-muted" id="previewMeta"></p>
                <hr>
                <div id="previewDescription"></div>
            </div>

        </div>
    </div>
</div>
