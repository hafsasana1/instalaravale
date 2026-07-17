@php
    use Illuminate\Support\Facades\File;
    $canProceed = true;
@endphp

<x-installer.layout title="Requirements">
    <div class="heading">
        <h2>Requirements</h2>
        <p>Make sure that all the requirements are met.</p>
    </div>

    <div class="requirements">
        <h3>Please configure PHP to match following requirements / settings</h3>

        <div class="table">
            <table>
                <thead>
                <tr>
                    <th>PHP Settings</th>
                    <th>Required</th>
                    <th>Current</th>
                    <th class="status">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $passed = version_compare(PHP_VERSION, '8.0.2') >= 0;
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">PHP Version</span></td>
                    <td>8.0.2+ (8.1.0+ Recommended)</td>
                    <td>{{PHP_VERSION}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = ini_get("allow_url_fopen");
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">allow_url_fopen</span></td>
                    <td>On</td>
                    <td>{{$passed ? "On" : "Off"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3>Please make sure following extensions are installed and enabled</h3>

        <div class="table">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Required</th>
                    <th>Current</th>
                    <th class="status">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $curl = function_exists("curl_version") ? curl_version() : false;
                    $passed = !empty($curl["version"]) && version_compare($curl["version"], '7.55') >= 0;
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">cURL</span></td>
                    <td>7.55.0+</td>
                    <td>{{!empty($curl["version"]) ? $curl["version"] : "Not installed"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $openssl = extension_loaded('openssl');
                    if ($openssl && !empty(OPENSSL_VERSION_NUMBER)) {
                        $installed_openssl_version = get_openssl_version_number(OPENSSL_VERSION_NUMBER);
                    }
                    $passed = !empty($installed_openssl_version) && $installed_openssl_version >= "1.0.2k";
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">OpenSSL</span></td>
                    <td>1.0.2k+</td>
                    <td>{{!empty($installed_openssl_version) ? $installed_openssl_version : "Outdated or not installed"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = defined('PDO::ATTR_DRIVER_NAME');
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">PDO</span></td>
                    <td>On</td>
                    <td>{{$passed ? "On" : "Off"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = function_exists('mysqli_connect');
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">mysqli</span></td>
                    <td>On</td>
                    <td>{{$passed ? "On" : "Off"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = extension_loaded('gd') && function_exists('gd_info');
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">GD</span></td>
                    <td>On</td>
                    <td>{{$passed ? "On" : "Off"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = extension_loaded('mbstring') && function_exists('mb_get_info');
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">mbstring</span></td>
                    <td>On</td>
                    <td>{{$passed ? "On" : "Off"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = extension_loaded('json') && function_exists('json_decode');
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">json</span></td>
                    <td>On</td>
                    <td>{{$passed ? "On" : "Off"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = extension_loaded('xml') && class_exists('DOMDocument');
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">xml</span></td>
                    <td>On</td>
                    <td>{{$passed ? "On" : "Off"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = function_exists('exif_read_data');
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">EXIF</span></td>
                    <td>On</td>
                    <td>{{$passed ? "On" : "Off"}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3>Please make sure following files and directories (including subdirectories) are writable</h3>

        <div class="table">
            <table>
                <thead>
                <tr>
                    <th>Directory/File</th>
                    <th class="status">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $passed = File::isWritable(base_path('.env'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/.env</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(base_path('bootstrap/cache'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/bootstrap/cache</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(public_path());
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">{{'/'.basename(public_path())}}</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(storage_path());
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/storage</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(storage_path('/app'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/storage/app</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(storage_path('/app/config'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/storage/app/config</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(storage_path('/app/public'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/storage/app/public</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(storage_path('/framework/cache'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/storage/framework/cache</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(storage_path('/framework/sessions'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/storage/framework/sessions</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(storage_path('/framework/views'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/storage/framework/views</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(storage_path('/logs'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/logs</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $passed = File::isWritable(base_path('/themes/config.json'));
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/themes/config.json</span></td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3>Please make sure following files have correct permissions</h3>

        <div class="table">
            <table>
                <thead>
                <tr>
                    <th>File</th>
                    <th>Recommended</th>
                    <th>Current</th>
                    <th class="status">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $permissions = fileperms(public_path('index.php'));
                    $passed = $permissions >= 0644;
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/{{basename(public_path())}}/index.php</span></td>
                    <td>0644</td>
                    <td>{{substr(sprintf('%o', $permissions), -4)}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                @php
                    $permissions = fileperms(base_path('artisan'));
                    $passed = $permissions >= 0755;
                    $canProceed = $canProceed && $passed;
                @endphp
                <tr @class(['is-error'=> !$passed])>
                    <td><span class="fw-700">/artisan</span></td>
                    <td>0755</td>
                    <td>{{substr(sprintf('%o', $permissions), -4)}}</td>
                    <td class="status">
                        <x-installer.status :passed="$passed"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <x-slot:footer>
        <a href="{{route('installer.index')}}" class="button">Back</a>
        @if($canProceed)
            <a href="{{route('installer.license')}}" class="button is-primary">Continue</a>
        @endif
    </x-slot:footer>
</x-installer.layout>
