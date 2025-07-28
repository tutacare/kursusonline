<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($material->type == 'pdf')
                        <iframe src="{{ route('student.materials.stream', $material->encrypted_id) }}" width="100%"
                            height="600px"></iframe>
                    @elseif ($material->type == 'video')
                        @php
                            $videoId = '';
                            $url = $material->file_path;
                            if (
                                preg_match(
                                    '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i',
                                    $url,
                                    $matches,
                                )
                            ) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        @if ($videoId)
                            <iframe width="100%" height="600px" src="https://www.youtube.com/embed/{{ $videoId }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        @else
                            <p>Invalid video URL.</p>
                        @endif
                    @else
                        <p>Unsupported material type.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
