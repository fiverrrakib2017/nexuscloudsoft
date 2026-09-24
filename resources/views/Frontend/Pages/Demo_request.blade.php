<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request a Free Demo</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 md:p-8">

    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-5 border border-slate-100">
        
        <!-- Left Side: Info / Branding -->
        <div class="md:col-span-2 bg-gradient-to-br from-indigo-600 to-blue-700 p-8 text-white flex flex-col justify-between">
            <div>
                <span class="inline-block px-3 py-1 bg-white/20 text-xs rounded-full font-medium mb-4 backdrop-blur-sm">Live Demo</span>
                <h2 class="text-2xl md:text-3xl font-bold leading-tight mb-4">আমাদের সিস্টেমের লাইভ ডেমো দেখুন</h2>
                <p class="text-indigo-100 text-sm leading-relaxed mb-6">
                    ফর্মটি পূরণ করুন। আমাদের টিম দ্রুত আপনার সাথে যোগাযোগ করবে এবং একটি ফ্রি ডেমো সেশন সেটিং করবে।
                </p>
            </div>

            <div class="space-y-4">
                <div class="flex items-center space-x-3 text-sm text-indigo-100">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white shrink-0">
                        <i class="fas fa-check"></i>
                    </div>
                    <span>সম্পূর্ণ ফ্রি কাস্টম ডেমো</span>
                </div>
                <div class="flex items-center space-x-3 text-sm text-indigo-100">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white shrink-0">
                        <i class="fas fa-headset"></i>
                    </div>
                    <span>২৪/৭ ডেডিকেটেড সাপোর্ট</span>
                </div>
                <div class="flex items-center space-x-3 text-sm text-indigo-100">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white shrink-0">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <span>তাৎক্ষণিক সেটআপ সুবিধা</span>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-white/10 text-xs text-indigo-200">
                &copy; {{ date('Y') }} All rights reserved.
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="md:col-span-3 p-6 md:p-10">
            
            <!-- Success Alert -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center space-x-3 text-sm">
                    <i class="fas fa-check-circle text-lg text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            

            <form action="{{ route('demo.request.store') }}" method="POST" class="space-y-5">
                @csrf 

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">আপনার নাম <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fas fa-user text-sm"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-indigo-500 focus:bg-white transition" 
                            placeholder="আপনার পূর্ণ নাম লিখুন">
                    </div>
                    @error('name') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">ফোন নম্বর <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fas fa-phone text-sm"></i>
                            </span>
                            <input type="text" name="phone" value="{{ old('phone') }}" 
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-indigo-500 focus:bg-white transition" 
                                placeholder="017XXXXXXXX">
                        </div>
                        @error('phone') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">ইমেইল এড্রেস</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-indigo-500 focus:bg-white transition" 
                                placeholder="example@mail.com">
                        </div>
                        @error('email') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">কোম্পানি / প্রতিষ্ঠানের নাম</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fas fa-building text-sm"></i>
                        </span>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-indigo-500 focus:bg-white transition" 
                            placeholder="আপনার কোম্পানির নাম">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">মেসেজ / বিস্তারিত</label>
                    <textarea name="message" rows="3"
                        class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-indigo-500 focus:bg-white transition" 
                        placeholder="আপনার প্রয়োজনীয় তথ্য লিখুন...">{{ old('message') }}</textarea>
                </div>

               <!-- বাটনের অংশ: হোম বাটন এবং সাবমিট বাটন -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button type="submit" id="submitDemoBtn"
                        class="w-full sm:w-1/2 py-3 px-6 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all duration-200 flex items-center justify-center space-x-2">
                        <span>রিকোয়েস্ট সাবমিট করুন</span>
                        <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                    <a href="{{ url('/') }}" 
                        class="w-full sm:w-1/2 py-3 px-6 bg-red-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 font-medium text-sm rounded-xl transition-all duration-200 flex items-center justify-center space-x-2 border border-red-200 text-center">
                        <i class="fas fa-home text-xs"></i>
                        <span>হোমে ফিরে যান</span>
                    </a>
                </div>
            </form>

        </div>
    </div>

</body>
</html>