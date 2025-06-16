@extends('layouts.base')

@section('title', 'Login')

@section('content')
    <div className="h-dvh w-screen overflow-hidden">
      <div className="grid grid-cols-1 md:grid-cols-2 h-full">
        <div className="w-full h-dvh flex-col justify-center items-center hidden md:flex">
          <div className="w-full flex flex-col items-center justify-center space-y-10">
            <h2 className="text-primary text-center space-y-2 py-10 font-bold text-xl md:text-3xl xl:text-4xl">
              <span className="block"> Selamat Datang di Vimedika!</span>
            </h2>
            <div className="w-full flex items-center justify-center">
              {{-- <Image
                src="/images/login-logo.png"
                alt="Login Logo"
                width={554}
                height={393}
                className="object-contain"
              /> --}}
            </div>
          </div>
        </div>
        <div className="bg-primary flex flex-col items-center justify-center px-6 relative">
          <div className="max-w-[24em] w-full">
            <div className="relative w-full h-16 mb-8 md:hidden flex items-center justify-center">
              {{-- <Image
                src="/images/logo-vimedika.png"
                alt="Logo Vimedika"
                fill
                sizes="(max-width: 768px) 100vw, 40rem"
                className="object-contain"
              /> --}}
            </div>
            <h2 className="text-center leading-relaxed mb-3 text-2xl md:text-3xl text-white font-bold">
              Sign In
            </h2>
            <p className="text-white text-center mb-8 font-medium">
              Masuk ke akun anda untuk melanjutkan
            </p>
            {{-- <Form {...credentials}>
              <form onSubmit={onSubmit} autoComplete="off">
                <div className="my-4">
                  <FormField
                    control={credentials.control}
                    name="username"
                    render={({ field }) => {
                      return (
                        <FormItem>
                          <FormLabel className="text-white">Username</FormLabel>
                          <FormControl>
                            <Input
                              type="text"
                              disabled={loadingSubmit}
                              {...field}
                            />
                          </FormControl>
                          <FormMessage className="text-white" />
                        </FormItem>
                      );
                    }}
                  />
                </div>
                <div className="my-4">
                  <FormField
                    control={credentials.control}
                    name="password"
                    render={({ field }) => {
                      return (
                        <FormItem>
                          <FormLabel className="text-white">Password</FormLabel>
                          <FormControl>
                            <div className="relative">
                              <Input
                                type={showPassword ? "text" : "password"}
                                disabled={loadingSubmit}
                                {...field}
                              />
                              <button
                                onClick={() => setShowPassword((prev) => !prev)}
                                type="button"
                                className="absolute top-0.5 right-0.5 bottom-0.5 rounded-r bg-transparent px-3 text-white"
                                disabled={loadingSubmit}
                              >
                                {showPassword ? (
                                  <LuEye className="w-5 h-5" />
                                ) : (
                                  <LuEyeOff className="w-5 h-5" />
                                )}
                              </button>
                            </div>
                          </FormControl>
                          <FormMessage className="text-white" />
                        </FormItem>
                      );
                    }}
                  />
                </div>
                <div className="flex w-full items-center justify-center mt-10">
                  <Button
                    type="submit"
                    disabled={loadingSubmit}
                    className="w-full font-semibold"
                    variant="buttonWhite"
                  >
                    {loadingSubmit ? (
                      <>
                        <LuLoader2 className="mr-2 h-4 w-4 animate-spin" />
                        <span>Loading</span>
                      </>
                    ) : (
                      <span>Login</span>
                    )}
                  </Button>
                </div>
              </form>
            </Form> --}}
          </div>
        </div>
      </div>
    </div>
@endsection
