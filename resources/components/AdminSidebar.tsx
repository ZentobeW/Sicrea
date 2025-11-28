import { LayoutDashboard, Calendar, Image, Users, LogOut, FileText, DollarSign } from 'lucide-react';
import { Flame } from 'lucide-react';

interface AdminSidebarProps {
  currentPage: string;
  onNavigate: (page: string) => void;
  onLogout: () => void;
}

export function AdminSidebar({ currentPage, onNavigate, onLogout }: AdminSidebarProps) {
  const menuItems = [
    { id: 'admin', icon: LayoutDashboard, label: 'Dashboard' },
    { id: 'admin-events', icon: Calendar, label: 'Kelola Event' },
    { id: 'admin-portfolio', icon: Image, label: 'Kelola Portofolio' },
    { id: 'admin-reports', icon: FileText, label: 'Laporan & Analitik' },
    { id: 'admin-refunds', icon: DollarSign, label: 'Kelola Refund' }
  ];

  return (
    <aside className="w-64 glass-khaky border-r-4 border-pink h-full flex flex-col">
      {/* Logo */}
      <div className="p-6 border-b-2 border-pink/30">
        <div className="flex items-center gap-2">
          <div className="gradient-pink-warm p-2 rounded-playful shadow-playful">
            <Flame className="w-5 h-5 text-maroon" />
          </div>
          <div>
            <h2 className="font-symphony font-bold text-maroon">Kreasi Hangat</h2>
            <p className="text-xs text-coklat font-open-sans">Admin Panel</p>
          </div>
        </div>
      </div>

      {/* Menu */}
      <nav className="flex-1 p-4">
        <ul className="space-y-2">
          {menuItems.map((item) => {
            const Icon = item.icon;
            const isActive = currentPage === item.id;
            return (
              <li key={item.id}>
                <button
                  onClick={() => onNavigate(item.id)}
                  className={`w-full flex items-center gap-3 px-4 py-2.5 rounded-playful transition-all font-open-sans ${
                    isActive
                      ? 'bg-pink text-maroon font-semibold shadow-playful scale-105'
                      : 'text-maroon hover:bg-pink/30 hover:scale-102'
                  }`}
                >
                  <Icon className="w-5 h-5" />
                  <span>{item.label}</span>
                </button>
              </li>
            );
          })}
        </ul>
      </nav>

      {/* Bottom Actions */}
      <div className="p-4 border-t-2 border-pink/30">
        <button
          onClick={() => onNavigate('home')}
          className="w-full flex items-center gap-3 px-4 py-2.5 rounded-playful text-maroon hover:bg-krem transition-all mb-2 font-open-sans hover:scale-102"
        >
          <LayoutDashboard className="w-5 h-5" />
          <span>Lihat Website</span>
        </button>
        <button
          onClick={onLogout}
          className="w-full flex items-center gap-3 px-4 py-2.5 rounded-playful text-destructive hover:bg-destructive/10 transition-all font-open-sans hover:scale-102"
        >
          <LogOut className="w-5 h-5" />
          <span>Logout</span>
        </button>
      </div>
    </aside>
  );
}
