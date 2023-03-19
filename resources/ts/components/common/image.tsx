import { ImgHTMLAttributes } from "react";

interface Props extends ImgHTMLAttributes<HTMLImageElement> {
  src: string;
  alt: string;
  loading?: 'lazy' | 'eager';
}

export default function Image({ src, alt, loading = 'lazy', ...rest }: Props) {
  return (
    <img
      src={src}
      alt={alt}
      loading={loading}
      {...rest}
    />
  );
}