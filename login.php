<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log in</title>
</head>
<body>
<div>
  <div>
    <div>
      <h2 >Sign in to your account</h2>
    </div>
    <form class="" action="#" method="POST">
      <input type="hidden" name="remember" value="true">
      <div>
        <div>
          <label for="email-address" class="">Email address</label>
          <input id="email-address" name="email" type="email" autocomplete="email" placeholder="Email address">
        </div>
        <div>
          <label for="password" class="">Password</label>
          <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Password">
        </div>
      </div>

      <div>
        <div class="flex items-center">
          <input id="remember-me" name="remember-me" type="checkbox" class="">
          <label for="remember-me" class="">Remember me</label>
        </div>

        <div>
          <a href="#" class="">Forgot your password?</a>
        </div>
      </div>

      <div>
        <button type="submit" class="">
          <span>
            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
            </svg>
          </span>
          Sign in
        </button>
      </div>
    </form>
  </div>
</div>
</body>
</html>