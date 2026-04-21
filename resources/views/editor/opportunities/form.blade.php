<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $opportunity->title ?? '') }}">
</div>

<div class="mb-3">
    <label>Type</label>
    <select name="type" class="form-control">
        <option value="internship">Internship</option>
        <option value="scholarship">Scholarship</option>
        <option value="grant">Grant</option>
        <option value="graduate_program">Graduate Program</option>
    </select>
</div>

<div class="mb-3">
    <label>Organization</label>
    <input type="text" name="organization" class="form-control"
        value="{{ old('organization', $opportunity->organization ?? '') }}">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" id="descriptionEditor" class="form-control" rows="5">{{ old('description', $opportunity->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Location</label>
    <input type="text" name="location" class="form-control"
        value="{{ old('location', $opportunity->location ?? '') }}">
</div>

<div class="mb-3">
    <label>Salary Range</label>
    <input type="text" name="salary_range" class="form-control"
        value="{{ old('salary_range', $opportunity->salary_range ?? '') }}">
</div>

<div class="mb-3">
    <label>Funding Type</label>
    <input type="text" name="funding_type" class="form-control"
        value="{{ old('funding_type', $opportunity->funding_type ?? '') }}">
</div>

<div class="mb-3">
    <label>Deadline</label>
    <input type="date" name="deadline" class="form-control"
        value="{{ old('deadline', $opportunity->deadline ?? '') }}">
</div>

<div class="mb-3">
    <label>Apply URL</label>
    <input type="url" name="apply_url" class="form-control"
        value="{{ old('apply_url', $opportunity->apply_url ?? '') }}">
</div>

<div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control">

    @if (isset($opportunity) && $opportunity->image)
        <div class="mt-2">
            <img src="{{ asset($opportunity->image) }}" width="120" class="rounded border">
        </div>
    @endif
</div>
