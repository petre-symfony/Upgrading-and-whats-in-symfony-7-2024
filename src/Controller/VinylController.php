<?php

namespace App\Controller;

use App\Repository\VinylMixRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController {
	public function __construct(
		#[Autowire(param: 'kernel.debug')]
		private bool $isDebug
	) {
	}

	#[Route('/', name: 'app_homepage')]
	public function homepage(
		#[MapQueryParameter()] string $query = '',
		#[MapQueryParameter()] int $page = 1,
		#[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 10
	): Response {
		dump($query, $page, $limit);
		$tracks = [
			['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
			['song' => 'Waterfalls', 'artist' => 'TLC'],
			['song' => 'Creep', 'artist' => 'Radiohead'],
			['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
			['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
			['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
		];

		return $this->render('vinyl/homepage.html.twig', [
			'title' => 'PB & Jams',
			'tracks' => $tracks,
		]);
	}

	#[Route('/browse/{slug}', name: 'app_browse')]
	public function browse(VinylMixRepository $mixRepository, Request $request, string $slug = null): Response {
		$genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

		$queryBuilder = $mixRepository->createOrderedByVotesQueryBuilder($slug);
		$adapter = new QueryAdapter($queryBuilder);
		$pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
			$adapter,
			$request->query->get('page', 1),
			9
		);

		return $this->render('vinyl/browse.html.twig', [
			'genre' => $genre,
			'pager' => $pagerfanta,
		]);
	}
}
