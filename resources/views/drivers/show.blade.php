@extends('layouts.app')

@section('title', 'View Driver CV - ' . ($item->full_name ?? 'N/A'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/components/cv-generate.css') }}" as="style">
@endpush

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Action Buttons -->
        <div class="no-print flex justify-end gap-3 mb-6">
            <a href="{{ route('drivers.index') }}" class="action-btn back-btn">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('drivers.edit', $item->id) }}" class="action-btn edit-btn">
                <i class="fas fa-edit"></i> Edit
            </a>
            {{-- <button onclick="printCV()" class="action-btn print-btn">
                <i class="fas fa-print"></i> Print CV
            </button> --}}
            <button onclick="downloadPDF()" class="action-btn pdf-btn">
                <i class="fas fa-file-pdf"></i> Download PDF
            </button>
        </div>

        <!-- CV Content -->
        <div class="cv-container">
            <!-- Header Section -->
            <div class="cv-header">
                <div>
                    <h1 class="cv-title print:text-[13pt] print:text-gray-900">{{ $item->full_name ?? 'N/A' }}</h1>
                    <span
                        class="cv-status @if ($item->getStatusLabelAttribute() === 'Active') status-active @elseif($item->getStatusLabelAttribute() === 'Inactive') status-inactive @else status-on-leave @endif">
                        {{ $item->getStatusLabelAttribute() ?? 'Unknown' }}
                    </span>
                </div>
                <div>
                    @if ($item->avatar_url)
                        <img src="{{ asset($item->avatar_url) }}" alt="Avatar"
                            class="avatar-img print:w-[25mm] print:h-[30mm]" loading="lazy">
                    @else
                        <img src="{{ asset('assets/images/default/user.png') }}" alt="Default Avatar"
                            class="avatar-img print:w-[25mm] print:h-[30mm]" loading="lazy">
                    @endif
                </div>
            </div>

            <!-- Personal Information -->
            <div class="cv-section">
                <h2 class="section-title">Personal Information</h2>
                <div class="info-grid">
                    <div class="info-item"><span class="info-label">Full Name:</span> {{ $item->full_name ?? 'N/A' }}
                    </div>
                    <div class="info-item"><span class="info-label">Father's Name:</span>
                        {{ $item->father_name ?? 'N/A' }}</div>
                    <div class="info-item"><span class="info-label">Phone:</span> {{ $item->phone ?? 'N/A' }}</div>
                    <div class="info-item"><span class="info-label">Birth Date:</span>
                        {{ $item->birth_date?->format('d-m-Y') ?? 'N/A' }}</div>
                    <div class="info-item"><span class="info-label">ID No.:</span> {{ $item->id_no ?? 'N/A' }}</div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="cv-section">
                <h2 class="section-title">Employment Information</h2>
                <div class="info-grid">
                    <div class="info-item"><span class="info-label">Transport:</span>
                        {{ $item->transport->transport_name ?? 'N/A' }}</div>
                    <div class="info-item"><span class="info-label">Department:</span>
                        {{ $item->department->department_name ?? 'N/A' }}</div>
                    <div class="info-item"><span class="info-label">Joining Date:</span>
                        {{ $item->joining_date?->format('d-m-Y') ?? 'N/A' }}</div>
                    <div class="info-item"><span class="info-label">Created By:</span>
                        {{ $item->creator->member_login ?? 'N/A' }}</div>
                </div>
            </div>

            <!-- Identification & Work Experience -->
            <div class="cv-section">
                <h2 class="section-title">Identification & Work Experience</h2>
                <div class="info-grid">
                    <div>
                        <h3 class="info-label">Identification</h3>
                        <div class="info-item"><span class="info-label">NID No.:</span> {{ $item->nid_no ?? 'N/A' }}
                        </div>
                        <div class="info-item"><span class="info-label">Driving License:</span>
                            {{ $item->driving_license_no ?? 'N/A' }}</div>
                        <div class="info-item"><span class="info-label">Insurance No.:</span>
                            {{ $item->insurance_no ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <h3 class="info-label">Work Experience</h3>
                        <div class="info-item"><span class="info-label">Reference:</span> {{ $item->reference ?? 'N/A' }}
                        </div>
                        <div class="info-item"><span class="info-label">Experience:</span>
                            {{ $item->pre_experience ?? '0' }} years</div>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="cv-section">
                <h2 class="section-title">Addresses</h2>
                <div class="info-grid">
                    <div class="info-item"><span class="info-label">Present Address:</span>
                        {{ $item->present_address ?? 'N/A' }}</div>
                    <div class="info-item"><span class="info-label">Permanent Address:</span>
                        {{ $item->permanent_address ?? 'N/A' }}</div>
                </div>
            </div>

            <!-- Attachments -->
            <div class="cv-section">
                <h2 class="section-title">Attachments</h2>
                @if (
                    $item->nid_front_attachment ||
                        $item->nid_back_attachment ||
                        $item->driving_license_front_attachment ||
                        $item->driving_license_back_attachment ||
                        $item->insurance_attachment)
                    <div class="attachments-grid">
                        <!-- NID Attachment -->
                        <div class="attachment-item">
                            <div class="attachment-label">NID</div>
                            @if ($item->nid_front_attachment)
                                <img src="{{ asset($item->nid_front_attachment) }}" alt="NID Front" class="attachment-img"
                                    loading="lazy">
                                <div class="attachment-side">Front Side</div>
                            @endif
                            @if ($item->nid_back_attachment)
                                <img src="{{ asset($item->nid_back_attachment) }}" alt="NID Back" class="attachment-img"
                                    loading="lazy">
                                <div class="attachment-side">Back Side</div>
                            @endif
                        </div>
                        <!-- Driving License Attachment -->
                        <div class="attachment-item">
                            <div class="attachment-label">Driving License</div>
                            @if ($item->driving_license_front_attachment)
                                <img src="{{ asset($item->driving_license_front_attachment) }}" alt="DL Front"
                                    class="attachment-img" loading="lazy">
                                <div class="attachment-side">Front Side</div>
                            @endif
                            @if ($item->driving_license_back_attachment)
                                <img src="{{ asset($item->driving_license_back_attachment) }}" alt="DL Back"
                                    class="attachment-img" loading="lazy">
                                <div class="attachment-side">Back Side</div>
                            @endif
                        </div>
                        <!-- Insurance Attachment -->
                        <div class="attachment-item">
                            <div class="attachment-label">Insurance</div>
                            @if ($item->insurance_attachment)
                                <img src="{{ asset($item->insurance_attachment) }}" alt="Insurance"
                                    class="attachment-img" loading="lazy">
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-gray-500 text-10pt print:text-[8pt]">No attachments available</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/pdf/html2pdf.bundle.min.js') }}"></script>
    <script>
        function preloadImages(images, callback) {
            let imagesToLoad = images.length;
            if (imagesToLoad === 0) {
                callback();
                return;
            }
            const imageLoaded = () => {
                imagesToLoad--;
                if (imagesToLoad === 0) {
                    callback();
                }
            };
            for (let i = 0; i < images.length; i++) {
                if (images[i].complete) {
                    imageLoaded();
                } else {
                    images[i].addEventListener('load', imageLoaded);
                    images[i].addEventListener('error', imageLoaded);
                }
            }
        }

        function printCV() {
            const original = document.querySelector('.cv-container');
            const clone = original.cloneNode(true);
            clone.style.position = 'static';
            clone.style.width = '200mm';
            clone.style.margin = '0';
            clone.style.padding = '4mm';
            clone.style.boxShadow = 'none';
            clone.style.background = 'white';
            document.body.appendChild(clone);

            const allElements = document.body.children;
            for (let i = 0; i < allElements.length; i++) {
                if (allElements[i] !== clone) {
                    allElements[i].style.display = 'none';
                }
            }

            const images = clone.getElementsByTagName('img');
            preloadImages(images, () => {
                setTimeout(() => {
                    window.print({
                        force: true
                    });
                    document.body.removeChild(clone);
                    for (let i = 0; i < allElements.length; i++) {
                        allElements[i].style.display = '';
                    }
                }, 1200);
            });
        }

        function downloadPDF() {
            const element = document.querySelector('.cv-container');
            const images = element.getElementsByTagName('img');
            const loading = document.createElement('div');
            loading.style.position = 'fixed';
            loading.style.top = '0';
            loading.style.left = '0';
            loading.style.width = '100%';
            loading.style.height = '100%';
            loading.style.backgroundColor = 'rgba(0,0,0,0.5)';
            loading.style.display = 'flex';
            loading.style.justifyContent = 'center';
            loading.style.alignItems = 'center';
            loading.style.zIndex = '9999';
            loading.innerHTML = '<div style="color: white; font-size: 24px;">Generating PDF... Please wait</div>';
            document.body.appendChild(loading);

            preloadImages(images, () => {
                const opt = {
                    margin: [5, 5, 5, 5],
                    filename: 'driver_cv_{{ $item->id_no ?? 'unknown' }}_{{ str_replace(' ', '_', $item->full_name ?? 'unknown') }}.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.99
                    },
                    html2canvas: {
                        scale: 4,
                        useCORS: true,
                        allowTaint: true,
                        logging: true
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait',
                        compress: true
                    },
                    pagebreak: {
                        mode: ['avoid-all', 'css']
                    }
                };
                html2pdf().set(opt).from(element).save().then(() => {
                    document.body.removeChild(loading);
                });
            });
        }
    </script>
@endpush
