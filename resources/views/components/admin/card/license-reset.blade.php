<div class="card license-card">
    <h4>License Usage Resets At</h4>
    <div class="license-card-content">
        <div class="license-usage">
            {{date('M j, Y', strtotime($licenseData('resets_at', 'now')))}}
        </div>
    </div>
</div>
