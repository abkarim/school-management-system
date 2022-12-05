import { Link as RouterLink } from "react-router-dom";
export default function Link({ children, ...props }) {
  return (
    <RouterLink className="underline hover:text-teal-500" {...props}>
      {children}
    </RouterLink>
  );
}
