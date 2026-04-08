{
  description = "Laravel Development Environment";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixos-unstable";
  };

  outputs = { self, nixpkgs }:
    let
      system = "x86_64-linux";
      pkgs = import nixpkgs { inherit system; };
      php = pkgs.php82;
    in
    {
      devShells.${system}.default = pkgs.mkShell {
        packages = with pkgs; [
          php
          phpPackages.composer
          nodejs_20
          just
          sqlite
        ];

        shellHook = ''
          echo "🚀 Laravel Nix Shell Activated"
          echo "🐘 PHP Version: $(php -v | head -n 1)"
          echo "📦 Node Version: $(node -v)"
          echo "🐳 Run 'just db-up' to start MySQL."

          export PATH="$HOME/.composer/vendor/bin:$PATH"
        '';
      };
    };
}
