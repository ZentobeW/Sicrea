import { Calendar, MapPin, Users, Tag } from 'lucide-react';
import { Card, CardContent, CardFooter } from './ui/card';
import { Badge } from './ui/badge';
import { Button } from './ui/button';
import { ImageWithFallback } from './figma/ImageWithFallback';
import type { Event } from '../lib/data';

interface EventCardProps {
  event: Event;
  onViewDetail: (eventId: string) => void;
}

export function EventCard({ event, onViewDetail }: EventCardProps) {
  const formatPrice = (price: number) => {
    if (price === 0) return 'Gratis';
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(price);
  };

  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
      day: 'numeric',
      month: 'long',
      year: 'numeric'
    }).format(date);
  };

  const spotsLeft = event.kuota - event.jumlahTerdaftar;

  return (
    <Card className="card-playful overflow-hidden group">
      <div className="relative overflow-hidden h-48">
        <ImageWithFallback
          src={event.image}
          alt={event.nama}
          className="w-full h-full object-cover group-hover:scale-110 group-hover:rotate-2 transition-all duration-500"
        />
        <div className="absolute top-3 right-3">
          <Badge className="sticker text-maroon font-open-sans">
            {event.kategori}
          </Badge>
        </div>
        {spotsLeft <= 5 && spotsLeft > 0 && (
          <div className="absolute top-3 left-3">
            <Badge variant="destructive" className="shadow-playful animate-pulse-soft font-open-sans">
              🔥 Hampir Penuh!
            </Badge>
          </div>
        )}
        {spotsLeft === 0 && (
          <div className="absolute inset-0 bg-maroon/80 flex items-center justify-center">
            <Badge variant="destructive" className="text-lg px-4 py-2 font-latuscha">
              Penuh
            </Badge>
          </div>
        )}
      </div>
      
      <CardContent className="p-5 bg-gradient-to-br from-white to-pink-muda/10">
        <h3 className="mb-3 line-clamp-2 min-h-[3rem] font-latuscha text-maroon">
          {event.nama}
        </h3>
        
        <div className="space-y-2 text-sm text-coklat font-open-sans">
          <div className="flex items-start gap-2">
            <Calendar className="w-4 h-4 mt-0.5 flex-shrink-0 text-pink" />
            <span>{formatDate(event.tanggal)}</span>
          </div>
          
          <div className="flex items-start gap-2">
            <MapPin className="w-4 h-4 mt-0.5 flex-shrink-0 text-pink" />
            <span className="line-clamp-1">{event.tempat}</span>
          </div>
          
          <div className="flex items-center gap-2">
            <Users className="w-4 h-4 flex-shrink-0 text-pink" />
            <span>{event.jumlahTerdaftar}/{event.kuota} peserta</span>
          </div>
        </div>
      </CardContent>
      
      <CardFooter className="p-5 pt-0 flex items-center justify-between bg-gradient-to-br from-white to-pink-muda/10">
        <div className="flex items-center gap-2">
          <Tag className="w-4 h-4 text-pink" />
          <span className="text-lg font-semibold text-maroon font-latuscha">
            {formatPrice(event.harga)}
          </span>
        </div>
        
        <Button
          onClick={() => onViewDetail(event.id)}
          disabled={spotsLeft === 0}
          className="btn-playful disabled:opacity-50 disabled:cursor-not-allowed"
        >
          Lihat Detail
        </Button>
      </CardFooter>
    </Card>
  );
}
