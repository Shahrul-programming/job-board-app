<div 
    x-data="infiniteScroll()"
    x-init="init()"
    id="job-container"
    class="space-y-8">
    
    @if($totalJobs > 0)
    <div class="text-center mb-6">
        <p class="text-gray-600 dark:text-gray-300">
            Showing {{ count($jobs) }} of {{ $totalJobs }} job{{ $totalJobs !== 1 ? 's' : '' }}
            @if(!empty($currentSearch))
                for "{{ $currentSearch }}"
            @endif
        </p>
    </div>
    @endif
    
    <div class="space-y-4">
        @forelse($jobs as $index => $job)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $job->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $job->company }}</p>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $job->location }}</p>
                        <p class="text-sm text-gray-500">Posted {{ $job->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="ml-4 flex space-x-2">
                        <button wire:click="viewJob({{ $job->id }})" class="text-green-500 hover:text-green-700 p-2">View</button>
                        @can('editJobs', auth()->user())
                        <button wire:click="editJob({{ $job->id }})" class="text-blue-500 hover:text-blue-700 p-2">Edit</button>
                        @endcan
                        @can('deleteJobs', auth()->user())
                        <button wire:click="deleteJob({{ $job->id }})" class="text-red-500 hover:text-red-700 p-2" onclick="return confirm('Are you sure you want to delete this job?')">Delete</button>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-500">No jobs found</p>
                @can('createJobs', auth()->user())
                <button wire:click="createJob" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Post a Job</button>
                @endcan
            </div>
        @endforelse
        
        <!-- Loading Skeleton - Show during loading -->
        <div wire:loading wire:target="loadMoreJobs" class="space-y-4">
            @for ($i = 1; $i <= 3; $i++)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 animate-pulse">
                <div class="flex justify-between items-start">
                    <div class="flex-1 space-y-3">
                        <!-- Title skeleton -->
                        <div class="h-6 bg-gray-300 dark:bg-gray-600 rounded-md w-3/4 loading-shimmer"></div>
                        <!-- Company skeleton -->
                        <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-1/2 loading-shimmer"></div>
                        <!-- Location skeleton -->
                        <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-1/3 loading-shimmer"></div>
                        <!-- Date skeleton -->
                        <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded w-1/4 loading-shimmer"></div>
                    </div>
                    <div class="ml-4 flex space-x-2">
                        <!-- Action buttons skeleton -->
                        <div class="h-8 w-12 bg-gray-300 dark:bg-gray-600 rounded loading-shimmer"></div>
                        <div class="h-8 w-12 bg-gray-300 dark:bg-gray-600 rounded loading-shimmer"></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Infinite Scroll Trigger -->
    @if($hasMore)
        <div 
            x-intersect="loadMore()"
            class="py-8 text-center">
            
            <!-- Loading State - Always show when loading -->
            <div wire:loading wire:target="loadMoreJobs" class="flex flex-col justify-center items-center space-y-4">
                <!-- Enhanced Loading Spinner -->
                <div class="relative">
                    <div class="animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
                    <div class="absolute inset-0 rounded-full h-12 w-12 border-4 border-transparent border-b-blue-400 animate-pulse"></div>
                </div>
                
                <!-- Loading Text with Animation -->
                <div class="flex items-center space-x-1">
                    <span class="text-blue-600 font-medium">Loading more jobs</span>
                    <div class="flex space-x-1">
                        <div class="w-1 h-1 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0ms;"></div>
                        <div class="w-1 h-1 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 150ms;"></div>
                        <div class="w-1 h-1 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 300ms;"></div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-64 bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full animate-pulse" 
                         style="width: {{ $totalJobs > 0 ? min((count($jobs) / $totalJobs) * 100, 100) : 0 }}%"></div>
                </div>
                
                <!-- Loading Stats -->
                <p class="text-sm text-gray-500">
                    Loaded <span class="font-semibold text-blue-600">{{ count($jobs) }}</span> 
                    of <span class="font-semibold">{{ $totalJobs }}</span> jobs
                </p>
            </div>
            
            <!-- Non-loading state -->
            <div wire:loading.remove wire:target="loadMoreJobs" class="text-gray-500 space-y-2">
                <div class="flex justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </div>
                <p class="text-sm">Scroll down to load more jobs</p>
                <p class="text-xs text-gray-400">{{ $totalJobs - count($jobs) }} jobs remaining</p>
            </div>
        </div>
    @else
        <div class="py-8 text-center space-y-4">
            <!-- Completion Animation -->
            <div class="flex justify-center">
                <div class="relative">
                    <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2" class="opacity-25"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12l2 2 4-4" class="animate-pulse"/>
                    </svg>
                </div>
            </div>
            
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">All jobs loaded!</h3>
                <p class="text-gray-500">
                    You've viewed all <span class="font-semibold text-green-600">{{ $totalJobs }}</span> available jobs
                </p>
            </div>
            
            <!-- Back to Top Button -->
            <button 
                onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
                Back to Top
            </button>
        </div>
    @endif

    <script>
        function infiniteScroll() {
            return {
                isScrolling: false,
                lastScrollTime: 0,
                
                init() {
                    // Throttled scroll listener for better performance
                    window.addEventListener('scroll', this.throttledHandleScroll.bind(this));
                    
                    // Add custom CSS for enhanced animations
                    this.addCustomStyles();
                },
                
                addCustomStyles() {
                    if (!document.getElementById('infinite-scroll-styles')) {
                        const style = document.createElement('style');
                        style.id = 'infinite-scroll-styles';
                        style.textContent = `
                            @keyframes fadeInUp {
                                from {
                                    opacity: 0;
                                    transform: translateY(30px);
                                }
                                to {
                                    opacity: 1;
                                    transform: translateY(0);
                                }
                            }
                            
                            @keyframes shimmer {
                                0% {
                                    background-position: -200px 0;
                                }
                                100% {
                                    background-position: 200px 0;
                                }
                            }
                            
                            .loading-shimmer {
                                background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.4), transparent);
                                background-size: 200px 100%;
                                animation: shimmer 1.5s infinite;
                            }
                            
                            .fade-in-up {
                                animation: fadeInUp 0.6s ease-out;
                            }
                            
                            .loading-pulse {
                                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                            }
                        `;
                        document.head.appendChild(style);
                    }
                },
                
                throttledHandleScroll() {
                    const now = Date.now();
                    if (now - this.lastScrollTime > 100) { // Throttle to every 100ms
                        this.lastScrollTime = now;
                        this.handleScroll();
                    }
                },
                
                handleScroll() {
                    // Prevent multiple simultaneous loading
                    if (this.isScrolling || this.$wire.loading) return;
                    
                    const scrollPosition = window.innerHeight + window.scrollY;
                    const documentHeight = document.documentElement.scrollHeight;
                    
                    // Trigger load when 300px from bottom for smoother experience
                    if (scrollPosition >= documentHeight - 300) {
                        this.loadMore();
                    }
                },
                
                loadMore() {
                    if (!this.$wire.loading && this.$wire.hasMore && !this.isScrolling) {
                        this.isScrolling = true;
                        
                        // Show visual feedback immediately
                        this.showLoadingFeedback();
                        
                        // Call Livewire method
                        this.$wire.call('loadMoreJobs').then(() => {
                            setTimeout(() => {
                                this.isScrolling = false;
                                this.addFadeInAnimation();
                            }, 200);
                        }).catch(() => {
                            this.isScrolling = false;
                        });
                    }
                },
                
                showLoadingFeedback() {
                    // Add haptic feedback for mobile if supported
                    if (navigator.vibrate) {
                        navigator.vibrate(50);
                    }
                    
                    // Smooth scroll adjustment to keep user in context
                    const currentJob = document.querySelector('[x-intersect]');
                    if (currentJob) {
                        currentJob.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'center' 
                        });
                    }
                },
                
                addFadeInAnimation() {
                    // Add fade-in animation to newly loaded jobs
                    const jobCards = document.querySelectorAll('.bg-white, .dark\\:bg-gray-800');
                    const recentJobs = Array.from(jobCards).slice(-5); // Last 5 loaded jobs
                    
                    recentJobs.forEach((card, index) => {
                        setTimeout(() => {
                            card.classList.add('fade-in-up');
                        }, index * 100);
                    });
                }
            }
        }
        
        // Add intersection observer for better performance
        document.addEventListener('DOMContentLoaded', function() {
            // Lazy loading for job images if any
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('loading-shimmer');
                            observer.unobserve(img);
                        }
                    }
                });
            });
            
            // Observe all images with data-src
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        });
    </script>
</div>
