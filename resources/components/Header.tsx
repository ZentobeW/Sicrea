import { Flame, Menu, X } from 'lucide-react';
import { useState } from 'react';
import { Button } from './ui/button';

interface HeaderProps {
  currentPage: string;
  onNavigate: (page: string) => void;
  userRole?: 'guest' | 'user' | 'admin';
  onLogout?: () => void;
}

export function Header({ currentPage, onNavigate, userRole = 'guest', onLogout }: HeaderProps) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const handleNavigate = (page: string) => {
    onNavigate(page);
    setMobileMenuOpen(false);
  };

  return (
    <header className="sticky top-0 z-50 bg-krem border-b-4 border-pink shadow-playful-lg">
      <div className="container mx-auto px-4 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <button 
            onClick={() => handleNavigate('home')}
            className="flex items-center gap-2 hover:scale-105 transition-transform"
          >
            <div className="gradient-pink-warm p-2 rounded-playful shadow-playful">
              <Flame className="w-6 h-6 text-maroon" />
            </div>
            <span className="text-xl font-symphony font-bold text-maroon">
              Kreasi Hangat
            </span>
          </button>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex items-center gap-4">
            <button 
              onClick={() => handleNavigate('home')}
              className={`font-open-sans px-4 py-2 rounded-playful transition-all ${
                currentPage === 'home' 
                  ? 'bg-pink text-maroon font-semibold shadow-playful' 
                  : 'text-maroon hover:bg-pink/30 hover:scale-105'
              }`}
            >
              Home
            </button>
            <button 
              onClick={() => handleNavigate('events')}
              className={`font-open-sans px-4 py-2 rounded-playful transition-all ${
                currentPage === 'events' 
                  ? 'bg-pink text-maroon font-semibold shadow-playful' 
                  : 'text-maroon hover:bg-pink/30 hover:scale-105'
              }`}
            >
              Events
            </button>
            <button 
              onClick={() => handleNavigate('portfolio')}
              className={`font-open-sans px-4 py-2 rounded-playful transition-all ${
                currentPage === 'portfolio' 
                  ? 'bg-pink text-maroon font-semibold shadow-playful' 
                  : 'text-maroon hover:bg-pink/30 hover:scale-105'
              }`}
            >
              Portofolio
            </button>
            <button 
              onClick={() => handleNavigate('partnership')}
              className={`font-open-sans px-4 py-2 rounded-playful transition-all ${
                currentPage === 'partnership' 
                  ? 'bg-pink text-maroon font-semibold shadow-playful' 
                  : 'text-maroon hover:bg-pink/30 hover:scale-105'
              }`}
            >
              Partnership
            </button>
            <button 
              onClick={() => handleNavigate('about')}
              className={`font-open-sans px-4 py-2 rounded-playful transition-all ${
                currentPage === 'about' 
                  ? 'bg-pink text-maroon font-semibold shadow-playful' 
                  : 'text-maroon hover:bg-pink/30 hover:scale-105'
              }`}
            >
              Tentang Kami
            </button>
          </nav>

          {/* Desktop Auth Buttons */}
          <div className="hidden md:flex items-center gap-3">
            {userRole === 'guest' ? (
              <>
                <Button 
                  variant="ghost" 
                  onClick={() => handleNavigate('login')}
                  className="hover:bg-pink/30 text-maroon font-open-sans"
                >
                  Login
                </Button>
                <Button 
                  onClick={() => handleNavigate('register')}
                  className="btn-playful"
                >
                  Registrasi
                </Button>
              </>
            ) : userRole === 'user' ? (
              <>
                <Button 
                  variant="ghost" 
                  onClick={() => handleNavigate('profile')}
                  className="hover:bg-pink/30 text-maroon font-open-sans"
                >
                  Profil Saya
                </Button>
                <Button 
                  variant="outline" 
                  onClick={onLogout}
                  className="border-2 border-pink text-maroon hover:bg-pink hover:text-maroon font-open-sans"
                >
                  Logout
                </Button>
              </>
            ) : (
              <>
                <Button 
                  variant="ghost" 
                  onClick={() => handleNavigate('admin')}
                  className="hover:bg-pink/30 text-maroon font-open-sans"
                >
                  Dashboard Admin
                </Button>
                <Button 
                  variant="outline" 
                  onClick={onLogout}
                  className="border-2 border-pink text-maroon hover:bg-pink hover:text-maroon font-open-sans"
                >
                  Logout
                </Button>
              </>
            )}
          </div>

          {/* Mobile Menu Button */}
          <button
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            className="md:hidden p-2 hover:bg-pink/30 rounded-playful transition-all hover:scale-105"
          >
            {mobileMenuOpen ? <X className="w-6 h-6 text-maroon" /> : <Menu className="w-6 h-6 text-maroon" />}
          </button>
        </div>

        {/* Mobile Menu */}
        {mobileMenuOpen && (
          <div className="md:hidden py-4 border-t-2 border-pink">
            <nav className="flex flex-col gap-2">
              <button
                onClick={() => handleNavigate('home')}
                className={`px-4 py-2 text-left rounded-playful transition-all font-open-sans ${
                  currentPage === 'home' ? 'bg-pink text-maroon font-semibold shadow-playful' : 'hover:bg-pink/30'
                }`}
              >
                Home
              </button>
              <button
                onClick={() => handleNavigate('events')}
                className={`px-4 py-2 text-left rounded-playful transition-all font-open-sans ${
                  currentPage === 'events' ? 'bg-pink text-maroon font-semibold shadow-playful' : 'hover:bg-pink/30'
                }`}
              >
                Events
              </button>
              <button
                onClick={() => handleNavigate('portfolio')}
                className={`px-4 py-2 text-left rounded-playful transition-all font-open-sans ${
                  currentPage === 'portfolio' ? 'bg-pink text-maroon font-semibold shadow-playful' : 'hover:bg-pink/30'
                }`}
              >
                Portofolio
              </button>
              <button
                onClick={() => handleNavigate('partnership')}
                className={`px-4 py-2 text-left rounded-playful transition-all font-open-sans ${
                  currentPage === 'partnership' ? 'bg-pink text-maroon font-semibold shadow-playful' : 'hover:bg-pink/30'
                }`}
              >
                Partnership
              </button>
              <button
                onClick={() => handleNavigate('about')}
                className={`px-4 py-2 text-left rounded-playful transition-all font-open-sans ${
                  currentPage === 'about' ? 'bg-pink text-maroon font-semibold shadow-playful' : 'hover:bg-pink/30'
                }`}
              >
                Tentang Kami
              </button>
              
              <div className="border-t border-border mt-2 pt-2">
                {userRole === 'guest' ? (
                  <>
                    <Button 
                      variant="ghost" 
                      className="w-full justify-start"
                      onClick={() => handleNavigate('login')}
                    >
                      Login
                    </Button>
                    <Button 
                      className="w-full mt-2 bg-primary hover:bg-primary/90"
                      onClick={() => handleNavigate('register')}
                    >
                      Registrasi
                    </Button>
                  </>
                ) : userRole === 'user' ? (
                  <>
                    <Button 
                      variant="ghost" 
                      className="w-full justify-start"
                      onClick={() => handleNavigate('profile')}
                    >
                      Profil Saya
                    </Button>
                    <Button 
                      variant="outline" 
                      className="w-full mt-2"
                      onClick={onLogout}
                    >
                      Logout
                    </Button>
                  </>
                ) : (
                  <>
                    <Button 
                      variant="ghost" 
                      className="w-full justify-start"
                      onClick={() => handleNavigate('admin')}
                    >
                      Dashboard Admin
                    </Button>
                    <Button 
                      variant="outline" 
                      className="w-full mt-2"
                      onClick={onLogout}
                    >
                      Logout
                    </Button>
                  </>
                )}
              </div>
            </nav>
          </div>
        )}
      </div>
    </header>
  );
}
