<div>
    <form method="GET" action="/home" class="mb-4">
        <div class="input-group">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>PendingStatus</option>
                <option value="COMPLETED" {{ request('status') == 'COMPLETED' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
    </form>

</div>
