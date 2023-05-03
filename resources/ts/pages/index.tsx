import { DefaultLayout } from "../layouts/default-layout";
import { ReactNode } from "react";
import { MarketStatistics } from "../types/statistics";
import { SummaryItem, SummaryItemFilters } from "../types/items";
import StatisticsBar from "../components/statistics-bar";
import SummaryItemsTable from "../components/summary-items-table";
import { Paginator } from "../types/pagination";
import SummaryItemsFiltersBar from "../components/summary-items-filters-bar";

interface Props {
  filters: Partial<SummaryItemFilters>;
  statistics: MarketStatistics;
  paginator: Paginator<SummaryItem>;
}

function Index({ filters, statistics, paginator }: Props) {
  return (
    <section className="py-4">
      <header>
        <h1 className="text-2xl font-semibold">
          Shadowpay market status
        </h1>
        <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm">
          Statistics <b>aslo includes</b> transactions that have been marked as <i>cancelled</i>.
        </p>
      </header>
      <div className="mt-4">
        <StatisticsBar statistics={statistics} />
      </div>
      <div className="mt-8">
        <SummaryItemsFiltersBar initialFilters={filters} />
        <SummaryItemsTable paginator={paginator} />
      </div>
    </section>
  );
}

Index.layout = (page: ReactNode) => (
  <DefaultLayout>
    {page}
  </DefaultLayout>
);

export default Index;