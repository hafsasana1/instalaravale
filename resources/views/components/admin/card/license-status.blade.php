<div class="card license-card">
    <h4>License Status</h4>
    <div class="license-card-content">
        <div @class(['license-status', $licenseStatus])>
            {{str($licenseStatus)->title()}}
        </div>
    </div>
</div>
