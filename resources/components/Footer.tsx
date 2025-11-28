import {
  Flame,
  Mail,
  Phone,
  MapPin,
  Facebook,
  Instagram,
  Twitter,
} from "lucide-react";

interface FooterProps {
  onNavigate: (page: string) => void;
}

export function Footer({ onNavigate }: FooterProps) {
  return (
    <footer className="bg-maroon text-broken-white mt-auto relative overflow-hidden">
      {/* Decorative Background */}
      <div className="absolute inset-0 opacity-10">
        <div className="absolute top-10 left-10 w-32 h-32 rounded-full bg-pink"></div>
        <div className="absolute bottom-10 right-10 w-40 h-40 rounded-full bg-krem"></div>
        <div className="absolute top-1/2 left-1/3 w-24 h-24 rounded-full bg-pink-muda"></div>
      </div>

      <div className="container mx-auto px-4 lg:px-8 py-12 relative z-10">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* Brand */}
          <div>
            <div className="flex items-center gap-2 mb-4">
              <div className="gradient-krem-pink p-2 rounded-playful shadow-playful">
                <Flame className="w-5 h-5 text-maroon" />
              </div>
              <span className="text-lg font-symphony font-bold">
                Kreasi Hangat
              </span>
            </div>
            <p className="text-pink-muda/90 text-sm leading-relaxed font-open-sans">
              Platform online untuk pendaftaran workshop, event,
              dan kegiatan kreatif. Wujudkan potensi kreatif
              Anda bersama kami.
            </p>
          </div>

          {/* Quick Links */}
          <div>
            <h3 className="font-latuscha font-semibold mb-4 text-krem">
              Navigasi
            </h3>
            <ul className="space-y-2">
              <li>
                <button
                  onClick={() => onNavigate("home")}
                  className="text-pink-muda/80 hover:text-pink hover:translate-x-1 transition-all text-sm font-open-sans inline-flex items-center gap-1"
                >
                  → Home
                </button>
              </li>
              <li>
                <button
                  onClick={() => onNavigate("events")}
                  className="text-pink-muda/80 hover:text-pink hover:translate-x-1 transition-all text-sm font-open-sans inline-flex items-center gap-1"
                >
                  → Events
                </button>
              </li>
              <li>
                <button
                  onClick={() => onNavigate("portfolio")}
                  className="text-pink-muda/80 hover:text-pink hover:translate-x-1 transition-all text-sm font-open-sans inline-flex items-center gap-1"
                >
                  → Portofolio
                </button>
              </li>
              <li>
                <button
                  onClick={() => onNavigate("partnership")}
                  className="text-pink-muda/80 hover:text-pink hover:translate-x-1 transition-all text-sm font-open-sans inline-flex items-center gap-1"
                >
                  → Partnership
                </button>
              </li>
              <li>
                <button
                  onClick={() => onNavigate("about")}
                  className="text-pink-muda/80 hover:text-pink hover:translate-x-1 transition-all text-sm font-open-sans inline-flex items-center gap-1"
                >
                  → Tentang Kami
                </button>
              </li>
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h3 className="font-latuscha font-semibold mb-4 text-krem">
              Kontak
            </h3>
            <ul className="space-y-3">
              <li className="flex items-start gap-2 text-pink-muda/80 text-sm font-open-sans">
                <MapPin className="w-4 h-4 mt-0.5 flex-shrink-0 text-pink" />
                <span>
                  Jl. Kreatif No. 123, Jakarta Selatan 12345
                </span>
              </li>
              <li className="flex items-center gap-2 text-pink-muda/80 text-sm font-open-sans">
                <Phone className="w-4 h-4 flex-shrink-0 text-pink" />
                <span>+62 812 3456 7890</span>
              </li>
              <li className="flex items-center gap-2 text-pink-muda/80 text-sm font-open-sans">
                <Mail className="w-4 h-4 flex-shrink-0 text-pink" />
                <span>info@kreasihangat.com</span>
              </li>
            </ul>
          </div>

          {/* Social Media */}
          <div>
            <h3 className="font-latuscha font-semibold mb-4 text-krem">
              Ikuti Kami
            </h3>
            <div className="flex gap-3">
              <a
                href="#"
                className="bg-pink-muda/20 p-2.5 rounded-playful hover:bg-pink hover:scale-110 transition-all"
                aria-label="Facebook"
              >
                <Facebook className="w-5 h-5 text-pink-muda" />
              </a>
              <a
                href="#"
                className="bg-pink-muda/20 p-2.5 rounded-playful hover:bg-pink hover:scale-110 transition-all"
                aria-label="Instagram"
              >
                <Instagram className="w-5 h-5 text-pink-muda" />
              </a>
              <a
                href="#"
                className="bg-pink-muda/20 p-2.5 rounded-playful hover:bg-pink hover:scale-110 transition-all"
                aria-label="Twitter"
              >
                <Twitter className="w-5 h-5 text-pink-muda" />
              </a>
            </div>
            <p className="text-stone-400 text-sm mt-4">
              Dapatkan update terbaru tentang workshop dan event
              kami!
            </p>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="border-t-2 border-pink-muda/30 mt-8 pt-6 text-center text-pink-muda/70 text-sm font-open-sans">
          <p>
            &copy; 2025 Kreasi Hangat. All rights reserved. Made
            with 💖
          </p>
        </div>
      </div>
    </footer>
  );
}